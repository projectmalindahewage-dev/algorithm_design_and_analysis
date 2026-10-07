<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Department;
use Illuminate\Database\Eloquent;
use DB;

class DepartmentRepository {

    private $departmentModel;

    public function __construct(){
        $this->departmentModel = new Department();
    }

    public function getDepartmentById($id) {
        try {
            return Department::where('id', $id)
                ->first();
        } catch (Exception $exc) {
            return $exc;
        }
    }

    public function getDepartmentList() {
        try {
            return $this->departmentModel
                ->orderby('id', 'ASC')
                ->get();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getActiveDepartmentList() {
        try {
            return $this->departmentModel
                ->where('status', '1')
                ->orderby('id', 'ASC')
                ->get();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
