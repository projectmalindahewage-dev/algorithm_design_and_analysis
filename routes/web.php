<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\AttendanceController@attendanceFormatting')->name('attendance.formatting');
Route::post('/attendance/formatting_process', 'App\Http\Controllers\AttendanceController@attendanceFormattingProcess')->name('attendance.formatting.process');
    