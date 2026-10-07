<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeInShift extends Model
{
    use HasFactory;

    protected $table = 'employee_in_shifts';

    protected $fillable = [
        'department_id',
        'employee_id',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function Department(){
    	return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }

    public function Employee(){
    	return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }
}
