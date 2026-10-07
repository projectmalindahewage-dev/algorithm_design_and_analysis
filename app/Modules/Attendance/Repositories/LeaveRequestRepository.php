<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\LeaveRequest;
use Illuminate\Database\Eloquent;
use DB;

class LeaveRequestRepository {

    private $leaveRequestModel;

    public function __construct(){
        $this->leaveRequestModel = new LeaveRequest();
    }

    public function getConfirmLeaveRequestWithDateBYDateAndEmployee($date, $employee_id){
        try {
            return DB::table('leave_requests')
                ->select('leave_requests.*', 'leave_request_dates.*')
                ->leftJoin('leave_request_dates', 'leave_requests.id', '=', 'leave_request_dates.leave_request_id')
                ->where('leave_requests.employee_id', $employee_id)
                ->where('leave_request_dates.leave_date', $date)
                ->where('leave_requests.status', 1)
                ->first();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}