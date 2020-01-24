<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helper;
use Config;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getDataPermohonan(Request $request)
    {
        $sdate = ($request->sdate)?$request->sdate." 00:00:00":date('Y-m-d H:i:s', strtotime("-7 days"));
        $edate = ($request->edate)?$request->edate." 23:59:59":date('Y-m-d H:i:s');
        
        $date = Helper::generateDateRange($sdate, $edate);

        $response = [];
        foreach ($date as $v) {
            $data =  DB::select("
                SELECT COUNT(CASE WHEN status = 'Permohonan berhasil diajukan' AND created_at LIKE '$v%' THEN 1 END) AS permohonan_diajukan,
                COUNT(CASE WHEN status = 'Permohonan ditolak petugas akademik' AND created_at LIKE '$v%' THEN 1 END) AS ditolak_petugas,
                COUNT(CASE WHEN status = 'Permohonan disetujui petugas akademik' AND created_at LIKE '$v%' THEN 1 END) AS disetujui_petugas,
                COUNT(CASE WHEN status = 'Permohonan disetujui kepala akademik' AND created_at LIKE '$v%' THEN 1 END) AS disetujui_kepala
                FROM permohonan"
            );

            $datas['date'] = date('j F Y', strtotime($v));
            $datas['data'] = $data;

            array_push($response, $datas); 
        }

        return $response;
    }
}
