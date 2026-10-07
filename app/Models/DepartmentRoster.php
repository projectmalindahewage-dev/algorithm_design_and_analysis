<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentRoster extends Model
{
    use HasFactory;

    protected $table = 'department_rosters';

    protected $fillable = [
        'department_id',
        'date',
        'shift_id',
        'employee_id',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function DepartmentShift(){
    	return $this->belongsTo('App\Models\DepartmentShift', 'shift_id', 'id');
    }

    public function Employee(){
    	return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

    public function Department(){
    	return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
}
