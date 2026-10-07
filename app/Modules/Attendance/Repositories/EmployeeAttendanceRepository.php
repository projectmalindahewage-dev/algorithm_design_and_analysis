<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\EmployeeAttendance;
use Illuminate\Database\Eloquent;
use DB;
use Carbon\Carbon;

class EmployeeAttendanceRepository {

    private $employeeAttendanceModel;

    public function __construct(){
        $this->employeeAttendanceModel = new EmployeeAttendance();
    }

    public function getNotFormatedAttendance() {
        return $this->employeeAttendanceModel
            ->where('formatted_status', false)
            ->where('status', '1')
            ->orderBy('employee_no')
            ->orderBy('in_time')
            ->orderBy('id')
            ->lockForUpdate()
            ->get();
    }

    public function markAsFormatted(array $attendanceIds): void
    {
        if ($attendanceIds === []) {
            return;
        }

        $this->employeeAttendanceModel
            ->whereIn('id', $attendanceIds)
            ->update(['formatted_status' => true]);
    }

    public function getAttendanceByUserAndInInTime($employee_no, $in_time) {
        try {
            return $this->employeeAttendanceModel
                ->where('employee_no', $employee_no)
                ->where('in_time', '=', $in_time)
                ->get();
        } catch (Exception $exc) {
            return $exc;
        }
    }
}
