@extends('admin/base')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Data SDM</h4>
                  <p class="card-description">
                    
                  </p>
                  <form method="post" action="{{ route('sdm.update', $sdm->id) }}">
                    @csrf
                    {{ method_field('PUT') }}
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $sdm->name }}" aria-label="Nama Lengkap">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $sdm->email }}" aria-label="Email">
                  </div>
                  <div class="form-group">
                    <label>NIP</label>
                    <input type="text" class="form-control" name="nip" id="nip" value="{{ $sdm->nip }}" aria-label="NIP">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect2">Role Name</label>
                    <select name="role_name" id="role_name" class="form-control" id="exampleFormControlSelect2">
                      <option value="">Pilih Role</option>
                      @foreach($roles as $data)
                        <option value="{{ $data->id }}" @if($sdm->role_id == $data->id) selected @endif>{{ $data->role_name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleTextarea1">Alamat</label>
                      <textarea class="form-control" name="alamat" id="alamat"id="exampleTextarea1" rows="2">{{ $sdm->alamat }}</textarea>
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlSelect2">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" id="exampleFormControlSelect2">
                      @if($sdm->jenis_kelamin == 1)
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="{{ $sdm->jenis_kelamin }}" selected>Laki-Laki</option>
                        <option value="2">Perempuan</option>
                      @elseif($sdm->jenis_kelamin == 2)
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="1">Laki-Laki</option>
                        <option value="{{ $sdm->jenis_kelamin }}" selected>Perempuan</option>
                      @else
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="1">Laki-Laki</option>
                        <option value="2">Perempuan</option>
                      @endif
                    </select>
                  </div>
                  <div class="form-group">
                      <label for="exampleTextarea1">Agama</label>
                      <input type="text" class="form-control" name="agama" id="agama" value="{{ $sdm->agama }}"></input>
                    </div>
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlSelect2">Status</label>
                    <select class="form-control" name="status" id="status" id="exampleFormControlSelect2">
                        @if($sdm->status == 1)
                          <option value="">Pilih Status</option>
                          <option value="{{ $sdm->status }}" selected>Aktif
                          </option>
                          <option value="2">Tidak Aktif</option>
                        @elseif($sdm->status == 2)
                          <option value="">Pilih Status</option>
                          <option value="1">Aktif</option>
                          <option value="{{ $sdm->status }}" selected>Tidak Aktif</option>
                        @else
                          <option value="">Pilih Status</option>
                          <option value="1">Aktif</option>
                          <option value="2" selected>Tidak Aktif</option>
                        @endif
                    </select>
                  </div>
                <button type="submit" class="btn btn-success mr-2">Update</button>
              </form>
              </div>
            </div>
@endsection