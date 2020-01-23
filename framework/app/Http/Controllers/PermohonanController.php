<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Permohonan;
use App\Surat;
use App\User;
use App\Prodi;
use App\Ak02;

use Auth;
use DB;
use Config;
use PDF;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id == 1) {
            return abort(401);
        }

        $permohonan = DB::table('permohonan')->leftJoin('users', 'users.id', '=', 'permohonan.user_id')
                        ->leftJoin('surat', 'surat.id', '=', 'permohonan.surat_id');

        if (Auth::user()->role_id == 4) {
            $permohonan = $permohonan->where('user_id', Auth::user()->id);
        }
        
        $permohonan = $permohonan->select('permohonan.*', 'users.name', 'surat.nama_surat', 'users.prodi_id')
                        ->get();

        return view('permohonan.index', compact('permohonan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role_id == 1) {
            return abort(401);
        }
        
        return view('permohonan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nama_dan_code = Config('constants.NAMA_SURAT_DAN_CODE.'.$request->cons);
        $suratindexing = Surat::where('code', $nama_dan_code[0])->orderBy('index_surat', 'DESC')->first();
        $aisurat = !empty($suratindexing) ? $suratindexing->index_surat + 1 : 1;
        $ak02 = "";
        $destinationPath = storage_path('app/public/images');
        if(!is_dir($destinationPath)){
            mkdir($destinationPath, 0755, true);
        }

        $request->validate([
            "bukti_tf"                            => "mimes:jpeg,png,jpg|max:500000",
            "cover_proposal"                      => "mimes:jpeg,png,jpg|max:500000",
            "surat_keterangan_persetujuan_sidang" => "mimes:jpeg,png,jpg|max:500000",
            "ijazah"                              => "mimes:jpeg,png,jpg|max:500000",
            "transkrip_nilai"                     => "mimes:jpeg,png,jpg|max:500000",
            "krs"                                 => "mimes:jpeg,png,jpg|max:500000",
            "berita_acara_bimbingan"              => "mimes:jpeg,png,jpg|max:500000",
            "ak01"                                => "mimes:jpeg,png,jpg|max:500000",
            "surat_tugas_bimbingan"               => "mimes:jpeg,png,jpg|max:500000",
            "penilaian_proposal"                  => "mimes:jpeg,png,jpg|max:500000",
            "data_diri"                           => "mimes:jpeg,png,jpg|max:500000",
            "pasfoto_3x4"                         => "mimes:jpeg,png,jpg|max:500000",
            "pasfoto_4x6"                         => "mimes:jpeg,png,jpg|max:500000",
            "foto_copy_ktp"                       => "mimes:jpeg,png,jpg|max:500000",

        ]);

        if ($nama_dan_code[0] == "KET-AAK02") {
            $ak02 = new Ak02();

            $arrPhoto = [
                $request->file('surat_keterangan_persetujuan_sidang'),
                $request->file('berita_acara_bimbingan'),
                $request->file('surat_tugas_bimbingan'),
                $request->file('ijazah'),
                $request->file('transkrip_nilai'),
                $request->file('krs'),
                $request->file('ak01'),
                $request->file('penilaian_proposal'),
                $request->file('data_diri'),
                $request->file('pasfoto_3x4'),
                $request->file('pasfoto_4x6'),
                $request->file('foto_copy_ktp')
            ];

            $arrFullName = [
                time().'_surat_keterangan_persetujuan_sidang.'.$arrPhoto[0]->getClientOriginalExtension(),
                time().'_berita_acara_bimbingan.'.$arrPhoto[1]->getClientOriginalExtension(),
                time().'_surat_tugas_bimbingan.'.$arrPhoto[2]->getClientOriginalExtension(),
                time().'_ijazah.'.$arrPhoto[3]->getClientOriginalExtension(),
                time().'_transkrip_nilai.'.$arrPhoto[4]->getClientOriginalExtension(),
                time().'_krs.'.$arrPhoto[5]->getClientOriginalExtension(),
                time().'_ak01.'.$arrPhoto[6]->getClientOriginalExtension(),
                time().'_penilaian_proposal.'.$arrPhoto[7]->getClientOriginalExtension(),
                time().'_data_diri.'.$arrPhoto[8]->getClientOriginalExtension(),
                time().'_pasfoto_3x4.'.$arrPhoto[9]->getClientOriginalExtension(),
                time().'_pasfoto_4x6.'.$arrPhoto[10]->getClientOriginalExtension(),
                time().'_foto_copy_ktp.'.$arrPhoto[11]->getClientOriginalExtension(),
            ];

            for ($i=0; $i < count($arrPhoto); $i++) { 
                $arrPhoto[$i]->move($destinationPath, $arrFullName[$i]);
            }

            $ak02->surat_keterangan_persetujuan_sidang = $arrFullName[0];
            $ak02->berita_acara_bimbingan              = $arrFullName[1];
            $ak02->surat_tugas_bimbingan               = $arrFullName[2];
            $ak02->ijazah                              = $arrFullName[3];
            $ak02->transkrip_nilai                     = $arrFullName[4];
            $ak02->krs                                 = $arrFullName[5];
            $ak02->ak01                                = $arrFullName[6];
            $ak02->penilaian_proposal                  = $arrFullName[7];
            $ak02->data_diri                           = $arrFullName[8];
            $ak02->pasfoto_3x4                         = $arrFullName[9];
            $ak02->pasfoto_4x6                         = $arrFullName[10];
            $ak02->foto_copy_ktp                       = $arrFullName[11];

            $ak02->created_by = Auth::user()->name;
            $ak02->save();
        }

        $surat = new Surat();
        $surat->index_surat = $aisurat;
        $surat->code = $nama_dan_code[0];
        $surat->nama_surat = $nama_dan_code[1];
        $surat->nomor_surat = "No.".$aisurat."/TRILOGI/ADAK/".$nama_dan_code[0]."/2020";

        if ($ak02 != "") {
            $surat->ak02_id = $ak02->id;
        }

        if (!empty($request->catatan_magang)) {
            $surat->catatan_surat = $request->catatan_magang;
        }

        if (!empty($request->catatan_cuti)) {
            $surat->catatan_surat = $request->catatan_cuti;
        }

        if (!empty($request->bukti_tf)) {
            $bukti_tf = $request->file('bukti_tf');
            $fullBuktitfName = time().'_buktitf.'.$bukti_tf->getClientOriginalExtension();
            $bukti_tf->move($destinationPath, $fullBuktitfName);  
            $surat->bukti_tf = $fullBuktitfName;
        }

        if (!empty($request->cover_proposal)) {
            $cover_proposal = $request->file('cover_proposal');
            $fullCoverProposalName = time().'_coverproposal.'.$cover_proposal->getClientOriginalExtension();  
            $cover_proposal->move($destinationPath, $fullCoverProposalName); 
            $surat->cover_proposal = $fullCoverProposalName;
        }

        $surat->created_by = Auth::user()->name;
        $surat->save();

        $permohonan = new Permohonan();
        $permohonan->user_id = Auth::user()->id;
        $permohonan->surat_id = $surat->id;
        $permohonan->status = Config('constants.PERMOHONAN_BERHASIL_DIAJUKAN');

        if (!empty($request->bukti_tf) || !empty($request->cover_proposal)) {
            $permohonan->prasyarat = 1;
        } elseif(!empty($request->catatan_cuti) || !empty($request->catatan_magang)) {
            $permohonan->prasyarat = 2;
        } elseif ($nama_dan_code[0] == "KET-AAK02") {
            $permohonan->prasyarat = 3;
        } else {
            $permohonan->prasyarat = 0;
        }

        $permohonan->created_by = Auth::user()->name;
        $permohonan->save();

        return redirect()->route('permohonan.index')->with('alert', 'Permohonan berhasil dibuat!');
    }

    public function updatePratinjau(Request $request)
    {
        $destinationPath = storage_path('app/public/images');
        if(!is_dir($destinationPath)){
            mkdir($destinationPath, 0755, true);
        }

        $request->validate([
            "bukti_tf"                            => "mimes:jpeg,png,jpg|max:500000",
            "cover_proposal"                      => "mimes:jpeg,png,jpg|max:500000",
            "prasyarat_ak02"                      => "mimes:jpeg,png,jpg|max:500000",
            "surat_keterangan_persetujuan_sidang" => "mimes:jpeg,png,jpg|max:500000",
            "ijazah"                              => "mimes:jpeg,png,jpg|max:500000",
            "transkrip_nilai"                     => "mimes:jpeg,png,jpg|max:500000",
            "krs"                                 => "mimes:jpeg,png,jpg|max:500000",
            "berita_acara_bimbingan"              => "mimes:jpeg,png,jpg|max:500000",
            "ak01"                                => "mimes:jpeg,png,jpg|max:500000",
            "surat_tugas_bimbingan"               => "mimes:jpeg,png,jpg|max:500000",
            "penilaian_proposal"                  => "mimes:jpeg,png,jpg|max:500000",
            "data_diri"                           => "mimes:jpeg,png,jpg|max:500000",
            "pasfoto_3x4"                         => "mimes:jpeg,png,jpg|max:500000",
            "pasfoto_4x6"                         => "mimes:jpeg,png,jpg|max:500000",
            "foto_copy_ktp"                       => "mimes:jpeg,png,jpg|max:500000",

        ]);

        if (!empty($request->ak02_id)) {
            $ak02 = Ak02::find($request->ak02_id);

            $arrPhoto = [
                $request->file('surat_keterangan_persetujuan_sidang'),
                $request->file('berita_acara_bimbingan'),
                $request->file('surat_tugas_bimbingan'),
                $request->file('ijazah'),
                $request->file('transkrip_nilai'),
                $request->file('krs'),
                $request->file('ak01'),
                $request->file('penilaian_proposal'),
                $request->file('data_diri'),
                $request->file('pasfoto_3x4'),
                $request->file('pasfoto_4x6'),
                $request->file('foto_copy_ktp'),
            ];

            $arrFullName = [
                ($arrPhoto[0] != null) ? time().'_surat_keterangan_persetujuan_sidang.'.$arrPhoto[0]->getClientOriginalExtension() : null,
                ($arrPhoto[1] != null) ? time().'_berita_acara_bimbingan.'.$arrPhoto[1]->getClientOriginalExtension() : null,
                ($arrPhoto[2] != null) ? time().'_surat_tugas_bimbingan.'.$arrPhoto[2]->getClientOriginalExtension() : null,
                ($arrPhoto[3] != null) ? time().'_ijazah.'.$arrPhoto[3]->getClientOriginalExtension() : null,
                ($arrPhoto[4] != null) ? time().'_transkrip_nilai.'.$arrPhoto[4]->getClientOriginalExtension() : null,
                ($arrPhoto[5] != null) ? time().'_krs.'.$arrPhoto[5]->getClientOriginalExtension() : null,
                ($arrPhoto[6] != null) ? time().'_ak01.'.$arrPhoto[6]->getClientOriginalExtension() : null,
                ($arrPhoto[7] != null) ? time().'_penilaian_proposal.'.$arrPhoto[7]->getClientOriginalExtension() : null,
                ($arrPhoto[8] != null) ? time().'_data_diri.'.$arrPhoto[8]->getClientOriginalExtension() : null,
                ($arrPhoto[9] != null) ? time().'_pasfoto_3x4.'.$arrPhoto[9]->getClientOriginalExtension() : null,
                ($arrPhoto[10] != null) ? time().'_pasfoto_4x6.'.$arrPhoto[10]->getClientOriginalExtension() : null,
                ($arrPhoto[11] != null) ? time().'_foto_copy_ktp.'.$arrPhoto[11]->getClientOriginalExtension() : null,
            ];

            for ($i=0; $i < count($arrPhoto); $i++) { 
                if ($arrPhoto[$i] != null) {
                    $arrPhoto[$i]->move($destinationPath, $arrFullName[$i]);
                }                
            }

            if ($arrFullName[0] != null) {
                $ak02->surat_keterangan_persetujuan_sidang = $arrFullName[0];
            }

            if ($arrFullName[1] != null) {
                $ak02->berita_acara_bimbingan              = $arrFullName[1];
            } 

            if ($arrFullName[2] != null) {
                $ak02->surat_tugas_bimbingan               = $arrFullName[2];
            } 

            if ($arrFullName[3] != null) {
                $ak02->ijazah                              = $arrFullName[3];
            } 

            if ($arrFullName[4] != null) {
                $ak02->transkrip_nilai                     = $arrFullName[4];
            } 

            if ($arrFullName[5] != null) {
                $ak02->krs                                 = $arrFullName[5];
            } 

            if ($arrFullName[6] != null) {
                $ak02->ak01                                = $arrFullName[6];
            } 

            if ($arrFullName[7] != null) {
                $ak02->penilaian_proposal                  = $arrFullName[7];
            } 

            if ($arrFullName[8] != null) {
                $ak02->data_diri                           = $arrFullName[8];
            }

            if ($arrFullName[9] != null) {
                $ak02->pasfoto_3x4                         = $arrFullName[9];
            } 

            if ($arrFullName[10] != null) {
                $ak02->pasfoto_4x6                         = $arrFullName[10];
            } 

            if ($arrFullName[11] != null) {
                $ak02->foto_copy_ktp                       = $arrFullName[11];
            }

            $ak02->updated_by = Auth::user()->name;
            $ak02->save();
        } else {
            $surat = Surat::find($request->surat_id);

            if (!empty($request->bukti_tf)) {
                $bukti_tf = $request->file('bukti_tf');

                $destinationPath = storage_path('app/public/images');
                if(!is_dir($destinationPath)){
                    mkdir($destinationPath, 0755, true);
                }
                $fullBuktitfName = time().'_buktitf.'.$bukti_tf->getClientOriginalExtension();
                $bukti_tf->move($destinationPath, $fullBuktitfName);  

                $surat->bukti_tf = $fullBuktitfName;
            }

            if (!empty($request->cover_proposal)) {
                $cover_proposal = $request->file('cover_proposal');

                $destinationPath = storage_path('app/public/images');
                if(!is_dir($destinationPath)){
                    mkdir($destinationPath, 0755, true);
                }
                $fullCoverProposalName = time().'_coverproposal.'.$cover_proposal->getClientOriginalExtension();  
                $cover_proposal->move($destinationPath, $fullCoverProposalName); 

                $surat->cover_proposal = $fullCoverProposalName;
            }

            $surat->save();
        }

        $permohonan = Permohonan::find($request->permohonan_id);

        if (!empty($request->bukti_tf)                
            || !empty($request->cover_proposal)
            || !empty($request->surat_keterangan_persetujuan_sidang)
            || !empty($request->berita_acara_bimbingan)
            || !empty($request->surat_tugas_bimbingan)
            || !empty($request->ijazah)
            || !empty($request->transkrip_nilai)
            || !empty($request->krs)
            || !empty($request->ak01)
            || !empty($request->penilaian_proposal)
            || !empty($request->data_diri)
            || !empty($request->pasfoto_3x4)
            || !empty($request->pasfoto_4x6)
            || !empty($request->foto_copy_ktp)
        ) {
            $permohonan->catatan = null;
            $permohonan->status = Config('constants.PERMOHONAN_BERHASIL_DIAJUKAN');
        }

        $permohonan->save();

        return redirect()->route('permohonan.index')->with('alert', 'Prasyarat berhasil diupdate!');
    }

    public function updateCatatan(Request $request)
    {
        $surat = Surat::find($request->id);

        if (!empty($request->catatan_surat)) {
            $surat->catatan_surat = $request->catatan_surat;
        }

        $surat->save();

        if (!empty($request->catatan_surat)) {
            $permohonan = Permohonan::find($request->permohonan_id);

            $permohonan->catatan = null;
            $permohonan->status = Config('constants.PERMOHONAN_BERHASIL_DIAJUKAN');
            $permohonan->save();
        }

        return redirect()->route('permohonan.index')->with('alert', 'Catatan berhasil diupdate!');
    }

    public function surat(Request $request)
    {
        $surat = Surat::find($request->surat_id);
        $user = User::find($request->user_id);
        $prodi = Prodi::find($user->prodi_id);

        if ($surat->code == "KET-AKTIF") {
            return view('surat.ket_aktif', compact('surat', 'user', 'prodi'));
        }

        if ($surat->code == "SRT-MAGANG") {
            return view('surat.ket_magang', compact('surat', 'user', 'prodi'));
        }

        if ($surat->code == "KET-CUTI") {
            return view('surat.ket_cuti', compact('surat', 'user', 'prodi'));
        }

        if ($surat->code == "KET-AAK01") {
            return view('surat.ket_ak01', compact('surat', 'user', 'prodi'));
        }
    }

    public function downloadPDF(Request $request)
    {
        $surat = Surat::find($request->surat_id);
        $user = User::find($request->user_id);
        $prodi = Prodi::find($user->prodi_id);

        if ($surat->code == "KET-AKTIF") {
            $pdf = PDF::loadview('surat.ket_aktif', ['surat' => $surat, 'user' => $user, 'prodi' => $prodi]);
            return $pdf->download('surat_keterangan_aktif');
        }

        if ($surat->code == "SRT-MAGANG") {
            $pdf = PDF::loadview('surat.ket_magang', ['surat' => $surat, 'user' => $user, 'prodi' => $prodi]);
            return $pdf->download('surat_keterangan_magang');
        }

        if ($surat->code == "KET-CUTI") {
            $pdf = PDF::loadview('surat.ket_cuti', ['surat' => $surat, 'user' => $user, 'prodi' => $prodi]);
            return $pdf->download('surat_keterangan_cuti');
        }

        if ($surat->code == "KET-AAK01") {
            $pdf = PDF::loadview('surat.ket_ak01', ['surat' => $surat, 'user' => $user, 'prodi' => $prodi]);
            return $pdf->download('surat_keterangan_ak01');
        }
    }

    public function terima($id)
    {
        $permohonan = Permohonan::find($id);
        $surat = Surat::find($permohonan->surat_id);

        if (Auth::user()->role_id == 3) {

            if ($surat->nama_surat == "KRS" || $surat->nama_surat == "Transkrip") {
                $permohonan->catatan = "Surat telah disetujui, Silahkan ambil dibagian akademik.";
            }

            $permohonan->status = Config('constants.PERMOHONAN_DISETUJUI_PETUGAS_AKADEMIK');
            $permohonan->save();
        }

        if (Auth::user()->role_id == 2) {
            $permohonan->status = Config('constants.PERMOHONAN_DISETUJUI_KEPALA_AKADEMIK');
            $permohonan->save();

            $surat->ttd_kabag_akademik = Config('constants.TTD_KABAG_AKADEMIK');
            $surat->tgl_acc_kabag = date('d M Y');
            $surat->save();
        }

        return redirect()->route('permohonan.index')->with('alert', 'Permohonan berhasil diterima!');
    }

    public function tolak(Request $request)
    {
        $permohonan = Permohonan::find($request->id);

        $permohonan->catatan = $request->catatan;
        $permohonan->status = Config('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK');
        $permohonan->save();

        return redirect()->route('permohonan.index')->with('alert', 'Permohonan berhasil ditolak!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
