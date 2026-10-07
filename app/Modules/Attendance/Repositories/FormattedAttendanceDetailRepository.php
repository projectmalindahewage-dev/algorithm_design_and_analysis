<?php

namespace App\Modules\Attendance\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\FormattedAttendanceDetail;
use Illuminate\Database\Eloquent;
use DB;
use Carbon\Carbon;

class FormattedAttendanceDetailRepository {

    private $formattedAttendanceModel;

    public function __construct(){
        $this->formattedAttendanceDetailModel = new FormattedAttendanceDetail();
    }

    public function createFormattedAttendanceDetail(array $data){
        try {
            return $this->formattedAttendanceDetailModel->create($data);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
