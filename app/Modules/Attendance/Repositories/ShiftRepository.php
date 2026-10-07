<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\DepartmentShift;
use Illuminate\Database\Eloquent;
use DB;

class ShiftRepository {

    private $departmentShiftModel;

    public function __construct(){
        $this->departmentShiftModel = new DepartmentShift();
    }

    public function getShiftById($id) {
        try {
            return DepartmentShift::where('id', $id)->first();
        } catch (Exception $exc) {
            return $exc;
        }
    }

    public function getShiftList() {
        try {
            return $this->departmentShiftModel
                ->orderby('id', 'ASC')
                ->get();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getActiveShiftList() {
        try {
            return $this->departmentShiftModel
                ->where('status', '1')
                ->orderby('id', 'ASC')
                ->get();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getDefaultShift() {
        try {
            return $this->departmentShiftModel
                ->where('department_id', '0')
                ->where('status', '1')
                ->first();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getShiftByDepartmentId($department_id) {
        try {
            return $this->departmentShiftModel
                ->where('department_id', $department_id)
                ->where('status', '1')
                ->orderby('id', 'ASC')
                ->get();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
