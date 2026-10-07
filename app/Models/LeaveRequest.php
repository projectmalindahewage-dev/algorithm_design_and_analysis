<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'leave_requests';

    protected $fillable = [
        'leave_request_id',
        'leave_date',
        'full_half_day',
        'leave_session',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];

    public function LeaveRequestDate(){
    	return $this->hasMany(LeaveRequestDate::class);
    }
}
