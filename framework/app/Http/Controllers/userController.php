<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Prodi;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::leftJoin('roles', 'roles.id', '=', 'users.role_id')
                    ->select('users.*', 'roles.role_name')
                    ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prodi = Prodi::get();

        return view('users.create', compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $users = new User();

        $users->nim_nip = $request->nim_nip;
        $users->name = $request->name;
        $users->password = bcrypt($request->nim_nip);
        $users->role_id = $request->role_id;
        $users->status = 1;
        $users->created_by = Auth::user()->name;

        if (!empty($request->prodi_id)) {
            $users->prodi_id = $request->prodi_id;
        }

        $users->save();

        return redirect()->route('users.index')->with('alert', 'Data berhasil ditambahkan!');
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
        $users = User::find($id);
        $prodi = Prodi::get();

        return view('users.edit', compact('users', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $users = User::find($request->id);

        $users->nim_nip = $request->nim_nip;
        $users->name = $request->name;
        $users->role_id = $request->role_id;
        $users->created_by = Auth::user()->name;

        if (!empty($request->prodi_id)) {
            $users->prodi_id = $request->prodi_id;
        }

        if (!empty($request->password)) {
            $users->password = bcrypt($request->password);
        }

        $users->save();

        return redirect()->route('users.index')->with('alert', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $users = User::find($request->user_id);
        $users->delete();

        return redirect()->route('users.index')->with('alert', 'Data berhasil dihapus!');
    }
}
