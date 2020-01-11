<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Permohonan;
use Config;

class Helper extends Model
{
    public static function countPetugasTask()
    {
    	$permohonan = Permohonan::where('status', Config('constants.PERMOHONAN_BERHASIL_DIAJUKAN'))->count();

    	return $permohonan;
    }

    public static function countKabagTask()
    {
    	$permohonan = Permohonan::leftJoin('surat', 'surat.id', '=', 'permohonan.surat_id')
    						->where('permohonan.status', Config('constants.PERMOHONAN_DISETUJUI_PETUGAS_AKADEMIK'))
    						->where('surat.nama_surat', '<>', "KRS")
    						->where('surat.nama_surat', '<>', "Transkrip")
    						->count();

    	return $permohonan;
    }
}
