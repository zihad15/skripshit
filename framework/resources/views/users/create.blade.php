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
          <select class="form-control" name="role_id" id="role_id" onchange="showDiv(this)">
            <option value="">Pilih roles untuk user.</option>
            <option value="4">Mahasiswa</option>
            <option value="3">Petugas Akademik</option>
            <option value="2">Kabag Akademik</option>
          </select>
        </div>
        <div class="form-group" id="prodi" style="display: none;">
          <label>Prodi</label>
          <select class="form-control" name="prodi_id" id="prodi_id">
            <option value="">Pilih prodi untuk mahasiswa.</option>
            @foreach($prodi as $v)
              <option value="{{ $v->id }}">{{ $v->nama_prodi }}</option>
            @endforeach
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
        document.getElementById('prodi').style.display = 'block';
        document.getElementById('prodi_id').required = true;
      } else {
        document.getElementById('prodi').style.display = 'none';
        document.getElementById('prodi_id').required = false;
      }
    }
  </script>
@endsection