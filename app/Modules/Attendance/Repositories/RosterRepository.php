<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\DepartmentRoster;
use Illuminate\Database\Eloquent;
use DB;

class RosterRepository {

    private $departmentRosterModel;

    public function __construct(){
        $this->departmentRosterModel = new DepartmentRoster();
    }

    public function checkEmployeeInRosterWithShiftByEmployeeIdAndDate($employee_id, $date) {
        try {
            return $this->departmentRosterModel
                ->where('employee_id', $employee_id)
                ->where('date', $date)
                ->where('status', '1')
                ->with('DepartmentShift')
                ->get();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }   
}
