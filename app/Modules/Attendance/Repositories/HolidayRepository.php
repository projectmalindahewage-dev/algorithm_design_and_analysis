<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Holiday;
use Illuminate\Database\Eloquent;
use DB;

class HolidayRepository {

    private $holidayModel;

    public function __construct(){
        $this->holidayModel = new Holiday();
    }

    public function dateCheckIsHoliday($date) {
        try {
            return Holiday::where('date', $date)
                ->where('status', 1)
                ->first();
        } catch (Exception $exc) {
            return $exc;
        }
    }
}
