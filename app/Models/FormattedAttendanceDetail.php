<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormattedAttendanceDetail extends Model
{
    use HasFactory;

    protected $table = 'formatted_attendance_details';

    protected $fillable = [
        'formatted_attendance_id',
        'attendance_referance_id',
        'in_date',
        'in_time',
        'out_date',
        'out_time',
        'shift_id',
        'roster_id',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function FormattedAttendance(){
    	return $this->belongsTo('App\Models\FormattedAttendance', 'formatted_attendance_id', 'id');
    }

    public function EmployeeAttendance(){
    	return $this->belongsTo('App\Models\EmployeeAttendance', 'attendance_referance_id', 'id');
    }

    public function SourceAttendances()
    {
        return $this->belongsToMany(
            EmployeeAttendance::class,
            'formatted_attendance_detail_sources',
            'formatted_attendance_detail_id',
            'employee_attendance_id'
        )->withTimestamps();
    }
}
