<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Employee;
use Illuminate\Database\Eloquent;
use DB;

class EmployeeRepository {

    private $employeeModel;

    public function __construct(){
        $this->employeeModel = new Employee();
    }

    public function getEmployeeWithDepartmentByEmployeNo($employeeNo) {
        try {
            return Employee::where('employee_no', $employeeNo)
                ->with('EmployeeDepartment.Department')
                ->first();
        } catch (Exception $exc) {
            return $exc;
        }
    }
}
