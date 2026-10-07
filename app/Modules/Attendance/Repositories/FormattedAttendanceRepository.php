<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\FormattedAttendance;
use Illuminate\Database\Eloquent;
use DB;
use Carbon\Carbon;

class FormattedAttendanceRepository {

    private $formattedAttendanceModel;

    public function __construct(){
        $this->formattedAttendanceModel = new FormattedAttendance();
    }

    public function createFormattedAttendance(array $data){
        try {
            return $this->formattedAttendanceModel->create($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
