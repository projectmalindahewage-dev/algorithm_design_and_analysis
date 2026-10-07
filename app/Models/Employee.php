<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'employee_no',
        'first_name',
        'last_name',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function EmployeeDepartment() {
        return $this->hasOne(EmployeeDepartment::class);
    }

    public function EmployeeAttendance(){
    	return $this->hasMany('App\Models\EmployeeAttendance');
    }

    public function FormattedAttendance(){
    	return $this->hasMany('App\Models\FormattedAttendance');
    }

    public function EmployeeInShift(){
    	return $this->hasMany('App\Models\EmployeeInShift');
    }

    public function DepartmentRoster(){
    	return $this->hasMany('App\Models\DepartmentRoster');
    }    
}
