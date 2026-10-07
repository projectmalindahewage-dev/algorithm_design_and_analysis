<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    use HasFactory;

    protected $table = 'employee_departments';

    protected $fillable = [
        'employee_id',
        'department_id',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function Employee() {
        return $this->belongsTo('App\Models\Employee', 'employee_id', 'id');
    }

    public function Department() {
        return $this->belongsTo('App\Models\Department', 'department_id', 'id');
    }
}
