<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\LeaveRequestDate;
use Illuminate\Database\Eloquent;
use DB;

class LeaveRequestDateRepository {

    private $leaveRequestDateModel;

    public function __construct(){
        $this->leaveRequestDateModel = new LeaveRequestDate();
    }

    public function getLeaveRequestDateByid(int $id) {
        try {
            return $this->leaveRequestDateModel->find($id);
        } catch (Exception $exc) {
            return $exc;
        }
    }
    
}
