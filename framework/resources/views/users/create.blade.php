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
      <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-group">
          <label>NIM/NIP</label>
          <input type="number" name="nim_nip" class="form-control">
        </div>
        <div class="form-group">
          <label>Nama Pengguna</label>
          <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
          <label>Roles</label>
          <select class="form-control" name="role_id" id="role_id" onchange="showDiv(this)" required>
            <option value="">Pilih roles untuk user.</option>
            <option value="4">Mahasiswa</option>
            <option value="2">Kabag Akademik</option>
          </select>
        </div>
        <div style="display: {{ (Auth::user()->role_id == 4) ? 'block' : 'none' }}" id="mahasiswa_requirements">
          <div class="form-group">
            <label>Prodi</label>
            <select class="form-control" name="prodi_id" id="prodi_id">
              <option value="">Pilih prodi untuk mahasiswa.</option>
              @foreach($prodi as $v)
                <option value="{{ $v->id }}">{{ $v->nama_prodi }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Jenjang Pendidikan</label>
            <select class="form-control" name="jenjang_pendidikan" id="jenjang_pendidikan">
              <option value="">Pilih jenjang pendidikan untuk mahasiswa.</option>
              <option value="strata satu">Strata Satu</option>
              <option value="strata dua">Strata Dua</option>
              <option value="strata tiga">Strata Tiga</option>
            </select>
          </div>
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