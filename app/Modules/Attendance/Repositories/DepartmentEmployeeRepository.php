<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\EmployeeDepartment;
use Illuminate\Database\Eloquent;
use DB;
use Carbon\Carbon;

class DepartmentEmployeeRepository {

    private $employeeDepartmentModel;

    public function __construct(){
        $this->employeeDepartmentModel = new EmployeeDepartment();
    }

}
