<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentShift extends Model
{
    use HasFactory;

    protected $table = 'department_shifts';

    protected $fillable = [
        'department_id',
        'shift_start_at',
        'shift_work_time',
        'ot_start_after',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function DepartmentRoster(){
    	return $this->hasMany('App\Models\DepartmentRoster');
    }

    public function Department(){
    	return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
}
