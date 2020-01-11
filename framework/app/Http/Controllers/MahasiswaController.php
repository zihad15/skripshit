<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Roles;
use Auth;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function homeMahasiswa()
    {
        return view('mahasiswa.index');
    }

    public function index()
    {   

        $mahasiswa = User::where('role_id', 2)->get();

        return view('admin.data_mahasiswa', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/tambah_data_mahasiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mahasiswa = new Mahasiswa();

        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->email = $request->email;
        $mahasiswa->tempat_lahir = $request->tempat_lahir;
        $mahasiswa->tanggal_lahir = $request->tanggal_lahir;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->agama_mhs = $request->agama_mhs;
        $mahasiswa->alamat_mhs = $request->alamat_mhs;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->status = $request->status;
        $mahasiswa->nik = $request->nik;
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index');
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
        $mahasiswa = User::where('id', $id)->first();
        $roles = Roles::get();

        return view('admin.update_data_mahasiswa', compact('mahasiswa', 'roles'));
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
        $mahasiswa = User::where('id', $id)->first();

        $mahasiswa->nim = $request->nim;
        $mahasiswa->name = $request->name;
        $mahasiswa->email = $request->email;
        $mahasiswa->tempat_lahir = $request->tempat_lahir;
        $mahasiswa->tanggal_lahir = $request->tanggal_lahir;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->agama = $request->agama;
        $mahasiswa->alamat = $request->alamat;
        $mahasiswa->jenis_kelamin = $request->jenis_kelamin;
        $mahasiswa->status = $request->status;
        $mahasiswa->nik = $request->nik;
        $mahasiswa->save();

        return redirect()->route('mahasiswa.index')->with('alert-success', 'Yeah Selamat!! Anda berhasil update data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $mahasiswa = User::where('id', $id)->first();
        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('alert-delete', 'Data Deleted Successfuly');
    }
}
