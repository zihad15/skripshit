<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

use DB;

class ReportExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;
    
    public function __construct($overall_filter, $filter_status, $sdate, $edate)
    {
        $this->overall_filter = $overall_filter;
        $this->filter_status = $filter_status;
        $this->sdate = $sdate;
        $this->edate = $edate;
    }

    public function collection()
    {
         $report = DB::table('permohonan')->leftJoin('users', 'users.id', '=', 'permohonan.user_id')
                        ->leftJoin('surat', 'surat.id', '=', 'permohonan.surat_id')
                        ->whereBetween('permohonan.created_at', array($this->sdate, $this->edate));;

        if ($this->overall_filter != "") {
            $report = $report->where('users.name', 'LIKE', '%'.$this->overall_filter.'%')
                        ->orwhere('surat.nama_surat', 'LIKE', '%'.$this->overall_filter.'%');
        }

        if ($this->filter_status != "") {
            $report = $report->where('permohonan.status', $this->filter_status);
        }

        $report = $report->select('permohonan.*', 'users.name', 'surat.nama_surat')->get();

        return $report;
    }

    public function map($report): array
    {   
        if ($report->prasyarat == 0) {
            $prasyarat = "No";
        } else {
            $prasyarat = "Yes";
        }

        return [
            $report->created_at,
            $report->name,
            $report->nama_surat,
            $prasyarat,
            $report->catatan,
            $report->status,
            $report->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal Permohonan',
            'Nama Mahasiswa',
            'Nama Surat',
            'Prasyarat / Catatan Surat',
            'Catatan',
            'Status',
            'Tanggal Update',
        ];
    }
}
