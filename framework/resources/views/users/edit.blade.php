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
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Form Pengguna Baru</h4>
      <p class="card-description">
        
      </p>
      <form method="POST" action="{{ url('users/update') }}">
        @csrf
        <input type="number" name="id" style="display: none;" value="{{ $users->id }}">
        <div class="form-group">
          <label>NIM/NIP</label>
          <input type="number" name="nim_nip" class="form-control" value="{{ $users->nim_nip }}">
        </div>
        <div class="form-group">
          <label>Nama Pengguna</label>
          <input type="text" name="name" class="form-control" value="{{ $users->name }}">
        </div>
        <div class="form-group">
          <label>Password &nbsp;</label><label style="color: red;">kosongkan jika tidak ingin merubah.</label>
          <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
          <label>Roles</label>
          <select class="form-control" name="role_id" id="role_id" onchange="showDiv(this)">
            <option value="">Pilih roles untuk user.</option>
            <option value="4" {{ ($users->role_id == 4) ? 'selected' : '' }}>Mahasiswa</option>
            <option value="3" {{ ($users->role_id == 3) ? 'selected' : '' }}>Petugas Akademik</option>
            <option value="2" {{ ($users->role_id == 2) ? 'selected' : '' }}>Kabag Akademik</option>
          </select>
        </div>
        <div style="display: {{ ($users->role_id == 4) ? 'block' : 'none' }}" id="mahasiswa_requirements">
          <div class="form-group">
            <label>Prodi</label>
            <select class="form-control" name="prodi_id" id="prodi_id">
              <option value="">Pilih prodi untuk mahasiswa.</option>
              @foreach($prodi as $v)
                <option value="{{ $v->id }}" {{ ($v->id == $users->prodi_id) ? 'selected' : '' }}>{{ $v->nama_prodi }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Jenjang Pendidikan</label>
            <select class="form-control" name="jenjang_pendidikan" id="jenjang_pendidikan">
              <option value="">Pilih jenjang pendidikan untuk mahasiswa.</option>
              <option value="strata satu" {{ ($users->jenjang_pendidikan == "strata satu") ? 'selected' : '' }}>Strata Satu</option>
              <option value="strata dua" {{ ($users->jenjang_pendidikan == "strata dua") ? 'selected' : '' }}>Strata Dua</option>
              <option value="strata tiga" {{ ($users->jenjang_pendidikan == "strata tiga") ? 'selected' : '' }}>Strata Tiga</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select class="form-control" name="status" id="status">
            <option value="">Pilih Status.</option>
            <option value="1" {{ ($users->status == 1) ? 'selected' : '' }}>Aktif</option>
            <option value="2" {{ ($users->status == 2) ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
        </div>
        <div class="form-group">
          <label>Status Mahasiswa</label>
          <select class="form-control" name="status_mahasiswa" id="status_mahasiswa">
            <option value="">Pilih Status.</option>
            <option value="1" {{ ($users->status_mahasiswa == 1) ? 'selected' : '' }}>Aktif</option>
            <option value="2" {{ ($users->status_mahasiswa == 2) ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success mr-2">Submit</button>
      </form>
  </div>
</div>
@endsection
@section('js')
  <script type="text/javascript">
    function showDiv(e)
    {
      if (e.value == 4) {
        document.getElementById('mahasiswa_requirements').style.display = 'block';
        document.getElementById('prodi_id').required                    = true;
        document.getElementById('jenjang_pendidikan').required          = true;
      } else {
        document.getElementById('mahasiswa_requirements').style.display = 'none';
        document.getElementById('prodi_id').required                    = false;
        document.getElementById('jenjang_pendidikan').required          = false;
      }
    }
  </script>
@endsection