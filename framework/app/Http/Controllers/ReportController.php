<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ReportExport;

use DB;
use Excel;
use DataTables;

class ReportController extends Controller
{
    public function index()
    {
    	return view('report.index');
    }

    public function fetchData()
    {	
        $overall_filter = !empty($_GET['overall_filter'])?$_GET['overall_filter']:"";
        $filter_status = !empty($_GET['filter_status'])?$_GET['filter_status']:"";
        $sdate = !empty($_GET['sdate']) ? $_GET['sdate']." 00:00:00" : "";
        $edate = !empty($_GET['edate']) ? $_GET['edate']." 23:59:59" : "";

        $report = DB::table('permohonan')->leftJoin('users', 'users.id', '=', 'permohonan.user_id')
                        ->leftJoin('surat', 'surat.id', '=', 'permohonan.surat_id');

        if ($overall_filter != "") {
        	$report = $report->where(function($q) use ($overall_filter){
                                $q->where('users.name', 'LIKE', '%'.$overall_filter.'%')
                                  ->orwhere('surat.nama_surat', 'LIKE', '%'.$overall_filter.'%');
                                });
        }

        if ($sdate != date('Y-m-d')) {
        	$report = $report->whereBetween('permohonan.created_at', array($sdate, $edate));
        }

        if ($filter_status != "") {
        	$report = $report->where('permohonan.status', $filter_status);
        }

        $report = $report->select('permohonan.*', 'users.name', 'surat.nama_surat');

        return Datatables::of($report)
        		->addColumn('prasyarat', function ($report) {
                    if ($report->prasyarat == 0) {
                    	return "No";
                    } else {
                    	return "Yes";
                    }
                })->make(true);
    }

    public function exportData(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        if ($request->sdate == "default") {
        	$sdate = date('Y-m-d', strtotime("-30 days"));
        	$edate = date('Y-m-d');
        } else {
            $sdate = $request->sdate;
            $edate = $request->edate;
        }

        $overall_filter = !empty($request->overall_filter)?$request->overall_filter:"";
        $filter_status = !empty($request->filter_status)?$request->filter_status:"";
        $sdate = $sdate." 00:00:00";
        $edate = $edate." 23:59:59";

        return (new ReportExport($overall_filter, $filter_status, $sdate, $edate))->download('Report_Export.xlsx');
    }
}
