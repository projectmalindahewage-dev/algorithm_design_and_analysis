<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'department_code',
        'department_name',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function EmployeeDepartment(){
    	return $this->hasMany('App\Models\EmployeeDepartment');
    }

    public function DepartmentShift(){
    	return $this->hasMany('App\Models\DepartmentShift');
    }

    public function DepartmentRoster(){
    	return $this->hasMany('App\Models\DepartmentRoster');
    }

    public function EmployeeInShift(){
    	return $this->hasMany('App\Models\EmployeeInShift');
    }
}
