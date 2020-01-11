<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Permohonan;
use App\Surat;
use App\User;
use App\Prodi;

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
        
        $permohonan = $permohonan->select('permohonan.*', 'users.name', 'surat.nama_surat')->get();

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

        $bukti_tf = !empty($request->bukti_tf) ? $request->bukti_tf : "";
        $cover_proposal = !empty($request->cover_proposal) ? $request->cover_proposal : "";
        $catatan_surat = !empty($request->catatan_surat) ? $request->catatan_surat : "";

        $request->validate([
            "bukti_tf" => "mimes:jpeg,png,jpg|max:500000",
            "cover_proposal" => "mimes:jpeg,png,jpg|max:500000"

        ]);

        $surat = new Surat();
        $surat->index_surat = $aisurat;
        $surat->code = $nama_dan_code[0];
        $surat->nama_surat = $nama_dan_code[1];
        $surat->nomor_surat = "No.".$aisurat."/TRILOGI/ADAK/".$nama_dan_code[0]."/2020";

        if ($catatan_surat != "") {
            $surat->catatan_surat = $catatan_surat;
        }

        if ($bukti_tf != "") {
            $bukti_tf = $request->file('bukti_tf');

            $destinationPath = storage_path('app/public/images');
            if(!is_dir($destinationPath)){
                mkdir($destinationPath, 0755, true);
            }
            $fullBuktitfName = time().'_buktitf.'.$bukti_tf->getClientOriginalExtension();
            $bukti_tf->move($destinationPath, $fullBuktitfName);  

            $surat->bukti_tf = $fullBuktitfName;
        }

        if ($cover_proposal != "") {
            $cover_proposal = $request->file('cover_proposal');

            $destinationPath = storage_path('app/public/images');
            if(!is_dir($destinationPath)){
                mkdir($destinationPath, 0755, true);
            }
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

        if ($bukti_tf != "" || $cover_proposal != "") {
            $permohonan->prasyarat = 1;
        } elseif($catatan_surat != "") {
            $permohonan->prasyarat = 2;
        } else {
            $permohonan->prasyarat = 0;
        }

        $permohonan->created_by = Auth::user()->name;
        $permohonan->save();

        return redirect()->route('permohonan.index')->with('alert', 'Permohonan berhasil dibuat!');
    }

    public function updatePratinjau(Request $request)
    {
        $bukti_tf = (!empty($request->bukti_tf) ? $request->bukti_tf : "");
        $cover_proposal = (!empty($request->cover_proposal) ? $request->cover_proposal : "");

        $request->validate([
            "bukti_tf" => "mimes:jpeg,png,jpg|max:500000",
            "cover_proposal" => "mimes:jpeg,png,jpg|max:500000"

        ]);

        $surat = Surat::find($request->surat_id);

        if ($bukti_tf != "") {
            $bukti_tf = $request->file('bukti_tf');

            $destinationPath = storage_path('app/public/images');
            if(!is_dir($destinationPath)){
                mkdir($destinationPath, 0755, true);
            }
            $fullBuktitfName = time().'_buktitf.'.$bukti_tf->getClientOriginalExtension();
            $bukti_tf->move($destinationPath, $fullBuktitfName);  

            $surat->bukti_tf = $fullBuktitfName;
        }

        if ($cover_proposal != "") {
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

        $permohonan = Permohonan::find($request->permohonan_id);

        if ($bukti_tf != "" || $cover_proposal != "") {
            $permohonan->catatan = null;
            $permohonan->status = Config('constants.PERMOHONAN_BERHASIL_DIAJUKAN');
        }

        $permohonan->save();

        return redirect()->route('permohonan.index')->with('alert', 'Prasyarat berhasil diupdate!');
    }

    public function updateCatatan(Request $request)
    {
        $catatan_surat = (!empty($request->catatan_surat) ? $request->catatan_surat : "");

        $surat = Surat::find($request->id);

        if ($catatan_surat != "") {
            $surat->catatan_surat = $catatan_surat;
        }

        $surat->save();

        if ($catatan_surat != "") {
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
