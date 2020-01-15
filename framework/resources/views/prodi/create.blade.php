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
      <h4 class="card-title">Form Prodi Baru</h4>
      <p class="card-description">
        
      </p>
      <form method="POST" action="{{ route('prodi.store') }}">
        @csrf
        <div class="form-group">
          <label>Kode Prodi</label>
          <input type="text" name="kode_prodi" class="form-control">
        </div>
        <div class="form-group">
          <label>Nama Prodi</label>
          <input type="text" name="nama_prodi" class="form-control">
        </div>
        <button type="submit" class="btn btn-success mr-2">Submit</button>
      </form>
  </div>
</div>
@endsection