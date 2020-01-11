<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Roles;
use DB;

class SdmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sdm = DB::table('users')
                    ->join('roles', 'roles.id', '=', 'users.role_id')
                    ->where('users.role_id', 1)
                    ->orWhere('users.role_id', 3)
                    ->orWhere('users.role_id', 4)
                    ->select('users.*', 'roles.role_name')
                    ->get();

        return view('admin.data_sdm', compact('sdm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $sdm = User::where('id', $id)->first();
        $roles = Roles::get();

        return view('admin.update_data_sdm', compact('sdm', 'roles'));
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
        $sdm = User::where('id', $id)->first();

        $sdm->name = $request->name;
        $sdm->email = $request->email;
        $sdm->nip = $request->nip;
        $sdm->role_id = $request->role_name;
        $sdm->agama = $request->agama;
        $sdm->alamat = $request->alamat;
        $sdm->jenis_kelamin = $request->jenis_kelamin;
        $sdm->status = $request->status;
        $sdm->save();

        return redirect()->route('sdm.index')->with('alert-success', 'Yeah Selamat!! Anda berhasil update data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sdm = User::where('id', $id)->first();
        $sdm->delete();

        return redirect()->route('sdm.index')->with('alert-delete', 'Data Deleted Successfuly');
    }
}
