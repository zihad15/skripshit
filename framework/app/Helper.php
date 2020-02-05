<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Permohonan;
use App\User;
use Config;

class Helper extends Model
{
    public static function countKabagTask()
    {
    	$permohonan = Permohonan::leftJoin('surat', 'surat.id', '=', 'permohonan.surat_id')
    						->where('permohonan.status', Config('constants.PERMOHONAN_BERHASIL_DIAJUKAN'))
    						->count();

    	return $permohonan;
    }

    public static function countFlexSM()
    {
        $users = User::where('flex_sm', 1)->count();

        return $users;
    }

    public static function generateDateRange($start_date, $end_date)
    {
        $period = new \DatePeriod(
             new \DateTime(date("Y-m-d", strtotime($start_date))),
             new \DateInterval('P1D'),
             new \DateTime(date("Y-m-d", strtotime($end_date)))
        );

        $dates = array();
        foreach($period as $date){
            array_push($dates, $date->format("Y-m-d"));
        }

        //push today date
        array_push($dates, date("Y-m-d", strtotime($end_date)));
        return $dates;
    }
}
