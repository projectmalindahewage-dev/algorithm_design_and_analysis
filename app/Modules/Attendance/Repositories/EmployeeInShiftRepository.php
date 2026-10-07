<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\EmployeeInShift;
use Illuminate\Database\Eloquent;
use DB;

class EmployeeInShiftRepository {

    private $employeeInShiftModel;

    public function __construct(){
        $this->employeeInShiftModel = new EmployeeInShift();
    }

    public function getEmployeeInShiftByEmployeeId($employee_id) {
        try {
            return $this->employeeInShiftModel
                ->where('employee_id', $employee_id)
                ->where('status', '1')
                ->first();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
