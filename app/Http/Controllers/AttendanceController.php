<?php
namespace App\Http\Controllers;

use App\Modules\Attendance\Services\AttendanceIntervalFormattingService;
use Illuminate\Http\Request;

class AttendanceController extends Controller {
    public AttendanceIntervalFormattingService $formattedAttendanceService;

    public function __construct(AttendanceIntervalFormattingService $formattedAttendanceService){
        $this->formattedAttendanceService = $formattedAttendanceService;
    }

    public function attendanceFormatting(){
        return view('attendance.attendance_format_index');
    }

    public function attendanceFormattingProcess(Request $request){
        $result = $this->formattedAttendanceService->process();

        return redirect()->route('attendance.formatting')
            ->with('status', 'Created '.$result['formatted_count'].' attendance segments from '.$result['processed_source_count'].' source records.');

    }

    
}
