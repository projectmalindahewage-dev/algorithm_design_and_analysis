<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    protected $table = 'holidays';

    protected $fillable = [
        'date',
        'description',
        'holiday_type',
        'start_time',
        'end_time',
        'status',
        'added_by',
        'added_date',
        'updated_by',
        'updated_date',
    ];
}
