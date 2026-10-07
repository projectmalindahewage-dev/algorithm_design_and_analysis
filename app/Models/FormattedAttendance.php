<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormattedAttendance extends Model
{
    use HasFactory;

    protected $table = 'formatted_attendances';

    protected $fillable = [
        'employee_id',
        'date',
        'day',
        'total_work_time',
        'weekend',
        'holiday',
        'off',
        'leave',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function FormattedAttendanceDetail(){
    	return $this->hasMany('App\Models\FormattedAttendanceDetail');
    }    

    public function Employee(){
    	return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }
}
