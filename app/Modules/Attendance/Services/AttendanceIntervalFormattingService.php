<?php

namespace App\Modules\Attendance\Services;

use App\Models\DepartmentRoster;
use App\Modules\Attendance\Repositories\EmployeeAttendanceRepository;
use App\Modules\Attendance\Repositories\EmployeeInShiftRepository;
use App\Modules\Attendance\Repositories\EmployeeRepository;
use App\Modules\Attendance\Repositories\FormattedAttendanceDetailRepository;
use App\Modules\Attendance\Repositories\FormattedAttendanceRepository;
use App\Modules\Attendance\Repositories\HolidayRepository;
use App\Modules\Attendance\Repositories\LeaveRequestRepository;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

/** Reconstructs midnight fragments and segments continuous work at roster changes. */
class AttendanceIntervalFormattingService
{
    public function __construct(
        private EmployeeAttendanceRepository $attendance,
        private EmployeeRepository $employees,
        private EmployeeInShiftRepository $employeeShifts,
        private FormattedAttendanceRepository $formatted,
        private FormattedAttendanceDetailRepository $details,
        private HolidayRepository $holidays,
        private LeaveRequestRepository $leaves,
    ) {}

    public function process(): array
    {
        return DB::transaction(function (): array {
            $pending = $this->attendance->getNotFormatedAttendance()->groupBy('employee_no');
            $processedIds = [];
            $segmentCount = 0;
            $shiftDepartments = config('constants.SHIFT_APLICABLE_DEPARTMENT', []);

            foreach ($pending as $employeeNo => $records) {
                $employee = $this->employees->getEmployeeWithDepartmentByEmployeNo($employeeNo);
                if (!$employee || !$employee->EmployeeDepartment) {
                    continue;
                }

                $intervals = $this->mergeMidnightFragments($records);
                if (!$intervals) {
                    continue;
                }

                $departmentId = (int) $employee->EmployeeDepartment->department_id;
                $usesRoster = in_array($departmentId, $shiftDepartments, true)
                    && (bool) $this->employeeShifts->getEmployeeInShiftByEmployeeId($employee->id);
                $windows = $usesRoster ? $this->rosterWindows($employee->id, $intervals) : [];
                $days = [];

                foreach ($intervals as $interval) {
                    foreach ($this->segmentAtRosterChanges($interval, $windows) as $segment) {
                        $date = $segment['start']->toDateString();
                        $days[$date] ??= ['minutes' => 0, 'off' => 0, 'segments' => []];
                        $shift = $this->matchingRoster($segment, $windows);
                        if ($date === $interval['start']->toDateString()) {
                            $days[$date]['off'] = max($days[$date]['off'], $this->offCredit($interval));
                        }
                        $days[$date]['segments'][] = [
                            'start' => $segment['start'],
                            'end' => $segment['end'],
                            'shift_id' => $shift['shift_id'] ?? null,
                            'roster_id' => $shift['roster_id'] ?? null,
                            'source_ids' => $interval['source_ids'],
                        ];

                        // Summary totals are calendar-day totals, even when a detail
                        // interval correctly remains whole across a shift's midnight.
                        $cursor = $segment['start'];
                        while ($cursor->lessThan($segment['end'])) {
                            $calendarDate = $cursor->toDateString();
                            $days[$calendarDate] ??= ['minutes' => 0, 'off' => 0, 'segments' => []];
                            $nextDay = $cursor->startOfDay()->addDay();
                            $pieceEnd = $segment['end']->lessThan($nextDay) ? $segment['end'] : $nextDay;
                            $days[$calendarDate]['minutes'] += $cursor->diffInMinutes($pieceEnd);
                            $cursor = $pieceEnd;
                        }
                    }
                    $processedIds = array_merge($processedIds, $interval['source_ids']);
                }

                foreach ($days as $date => $day) {
                    $holiday = $this->holidays->dateCheckIsHoliday($date);
                    $leave = $this->leaves->getConfirmLeaveRequestWithDateBYDateAndEmployee($date, $employee->id);
                    $summary = $this->formatted->createFormattedAttendance([
                        'employee_id' => $employee->id,
                        'date' => $date,
                        'day' => CarbonImmutable::parse($date)->format('D'),
                        'total_work_time' => $day['minutes'],
                        'weekend' => CarbonImmutable::parse($date)->isWeekend() ? 1 : 0,
                        'holiday' => $holiday?->holiday_type === 'FULL_DAY' ? 2 : ($holiday?->holiday_type === 'HALF_DAY' ? 1 : 0),
                        'off' => $day['off'],
                        'leave' => $leave?->full_half_day === 'FULL_DAY' ? 2 : ($leave?->full_half_day === 'HALF_DAY' ? 1 : 0),
                    ]);

                    foreach ($day['segments'] as $segment) {
                        $sourceIds = $segment['source_ids'];
                        $firstSourceId = $sourceIds[0];
                        $detail = $this->details->createFormattedAttendanceDetail([
                            'formatted_attendance_id' => $summary->id,
                            // Retained for compatibility; the pivot below is authoritative.
                            'attendance_referance_id' => $firstSourceId,
                            'in_date' => $segment['start']->toDateString(),
                            'in_time' => $segment['start']->format('H:i:s'),
                            'out_date' => $segment['end']->toDateString(),
                            'out_time' => $segment['end']->format('H:i:s'),
                            'shift_id' => $segment['shift_id'],
                            'roster_id' => $segment['roster_id'],
                            'status' => 1,
                            'added_by' => 1,
                        ]);
                        $detail->SourceAttendances()->syncWithoutDetaching($sourceIds);
                        $segmentCount++;
                    }
                }
            }

            $processedIds = array_values(array_unique($processedIds));
            $this->attendance->markAsFormatted($processedIds);

            return ['formatted_count' => $segmentCount, 'processed_source_count' => count($processedIds)];
        });
    }

    /** Merge only overlaps and the known artificial 23:59 / next-day 00:00 split. */
    private function mergeMidnightFragments($records): array
    {
        $valid = $records->filter(function ($record): bool {
            return $record->in_time && $record->out_time
                && CarbonImmutable::parse($record->out_time)->greaterThan(CarbonImmutable::parse($record->in_time));
        })->sortBy('in_time')->values();

        $intervals = [];
        foreach ($valid as $record) {
            $start = CarbonImmutable::parse($record->in_time);
            $end = CarbonImmutable::parse($record->out_time);
            $lastIndex = count($intervals) - 1;
            if ($lastIndex >= 0) {
                $last = $intervals[$lastIndex];
                $midnightPair = $last['end']->format('H:i:s') === '23:59:00'
                    && $start->format('H:i:s') === '00:00:00'
                    && $start->toDateString() === $last['end']->addDay()->toDateString();
                if ($midnightPair || $start->lessThanOrEqualTo($last['end'])) {
                    if ($end->greaterThan($last['end'])) {
                        $intervals[$lastIndex]['end'] = $end;
                    }
                    $intervals[$lastIndex]['source_ids'][] = (int) $record->id;
                    continue;
                }
            }
            $intervals[] = ['start' => $start, 'end' => $end, 'source_ids' => [(int) $record->id]];
        }

        foreach ($intervals as &$interval) {
            $interval['source_ids'] = array_values(array_unique($interval['source_ids']));
        }
        unset($interval);
        return $intervals;
    }

    private function rosterWindows(int $employeeId, array $intervals): array
    {
        $from = $intervals[0]['start']->subDay()->toDateString();
        $to = $intervals[count($intervals) - 1]['end']->addDay()->toDateString();
        $rosters = DepartmentRoster::query()->where('employee_id', $employeeId)
            ->where('status', '1')->whereBetween('date', [$from, $to])
            ->with('DepartmentShift')->orderBy('date')->get();

        $windows = [];
        foreach ($rosters as $roster) {
            if (!$roster->DepartmentShift) continue;
            $duration = $this->durationSeconds((string) $roster->DepartmentShift->shift_work_time);
            if ($duration <= 0) continue;
            $start = CarbonImmutable::parse($roster->date.' '.$roster->DepartmentShift->shift_start_at);
            $windows[] = [
                'start' => $start, 'end' => $start->addSeconds($duration),
                'shift_id' => (int) $roster->shift_id, 'roster_id' => (int) $roster->id,
            ];
        }
        usort($windows, fn ($a, $b) => $a['start']->getTimestamp() <=> $b['start']->getTimestamp());
        return $windows;
    }

    private function durationSeconds(string $duration): int
    {
        if (!preg_match('/^(\d{1,3}):(\d{2}):(\d{2})$/', $duration, $parts)) return 0;
        return ((int) $parts[1] * 3600) + ((int) $parts[2] * 60) + (int) $parts[3];
    }

    /** Use roster window ends as changeovers; this avoids an extra cut at a late clock-in. */
    private function segmentAtRosterChanges(array $interval, array $windows): array
    {
        $cuts = [$interval['start'], $interval['end']];
        foreach ($windows as $window) {
            if ($window['end']->greaterThan($interval['start']) && $window['end']->lessThan($interval['end'])) {
                $cuts[] = $window['end'];
            }
        }
        usort($cuts, fn ($a, $b) => $a->getTimestamp() <=> $b->getTimestamp());
        $segments = [];
        for ($i = 0; $i < count($cuts) - 1; $i++) {
            if ($cuts[$i]->lessThan($cuts[$i + 1])) {
                $segments[] = ['start' => $cuts[$i], 'end' => $cuts[$i + 1]];
            }
        }
        return $segments;
    }

    private function matchingRoster(array $segment, array $windows): ?array
    {
        $best = null;
        $bestOverlap = 0;
        foreach ($windows as $window) {
            $start = $segment['start']->greaterThan($window['start']) ? $segment['start'] : $window['start'];
            $end = $segment['end']->lessThan($window['end']) ? $segment['end'] : $window['end'];
            $overlap = $start->diffInSeconds($end, false);
            if ($overlap > $bestOverlap) {
                $bestOverlap = $overlap;
                $best = ['shift_id' => $window['shift_id'], 'roster_id' => $window['roster_id']];
            }
        }
        return $best;
    }

    private function offCredit(array $interval): int
    {
        if ($interval['end']->toDateString() <= $interval['start']->toDateString()) return 0;
        return $interval['end']->format('H:i:s') >= '02:00:00' ? 2 : 1;
    }
}
