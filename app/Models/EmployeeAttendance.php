<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $table = 'employee_attendances';

    protected $fillable = [
        'employee_no',
        'in_time',
        'out_time',
        'status',
        'formatted_status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function Employee(){
        return $this->belongsTo(Employee::class, 'employee_no', 'employee_no');
    }

    public function FormattedAttendanceDetail(){
    	return $this->hasMany('App\Models\FormattedAttendanceDetail');
    }
}
