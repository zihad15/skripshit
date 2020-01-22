@extends('layouts.app_base')
@section('content')
@section('css')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection
@if ($errors->any())
  <div class="alert alert-danger">
    <button data-dismiss="alert" class="close"></button>
      {!! implode('', $errors->all('<p>:message</p>')) !!}
  </div>
@endif
@if (session('alert'))
  <div class="alert alert-success">
      {{ session('alert') }}
  </div>
@endif
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Form Pengguna Baru</h4>
      <p class="card-description">
        
      </p>
      <form method="POST" action="{{ url('users/kelolaProfilSubmit') }}">
        @csrf
        <input type="number" name="user_id" style="display: none;" value="{{ $users->id }}">
        <div class="form-group">
          <label>NIM/NIP</label>
          <input type="number" name="nim_nip" class="form-control" value="{{ $users->nim_nip }}" readonly>
        </div>
        @if(Auth::user()->role_id == 4)
          <div class="form-group">
            <label>Prodi</label>
            @php($prodi = App\Prodi::find($users->prodi_id))
            <input type="text" name="prodi" class="form-control" value="{{ $prodi->nama_prodi }}" readonly>
          </div>
        @endif
        <div class="form-group">
          <label>Nama Pengguna</label>
          <input type="text" name="name" class="form-control" value="{{ $users->name }}">
        </div>
        <div class="form-group">
          <label>Tempat Lahir</label>
          <input type="text" name="tempat_lahir" class="form-control" value="{{ $users->tempat_lahir }}">
        </div>
        <div class="form-group">
          <label>Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" class="form-control" value="{{ $users->tanggal_lahir }}">
        </div>
        <div class="form-group">
          <label>Alamat</label>
          <textarea class="form-control" name="alamat">{{ $users->alamat }}</textarea>
        </div>
        <div class="form-group">
          <label>Jenis Kelamin</label>
          <select class="form-control" name="jenis_kelamin">
            <option value="L" {{ ($users->jenis_kelamin == "L") ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ ($users->jenis_kelamin == "P") ? 'selected' : '' }}>Perempuan</option>
          </select>
        </div>
        <div class="form-group">
          <label>Agama</label>
          <select class="form-control" name="agama">
            <option value="islam" {{ ($users->agama == "islam") ? 'selected' : '' }}>Islam</option>
            <option value="katolik" {{ ($users->agama == "katolik") ? 'selected' : '' }}>Katolik</option>
            <option value="protestan" {{ ($users->agama == "protestan") ? 'selected' : '' }}>Protestan</option>
            <option value="hindu" {{ ($users->agama == "hindu") ? 'selected' : '' }}>Hindu</option>
            <option value="budha" {{ ($users->agama == "budha") ? 'selected' : '' }}>Budha</option>
          </select>
        </div>
        <div class="form-group">
          <label>No Telp</label>
          <input type="text" name="no_hp" class="form-control" value="{{ $users->no_hp }}">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" class="form-control" value="{{ $users->email }}">
        </div>
        <div class="form-group">
          <label>Password &nbsp;</label><label style="color: red;">kosongkan jika tidak ingin merubah.</label>
          <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-success mr-2">Submit</button>
      </form>
  </div>
</div>
@endsection