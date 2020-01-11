@extends('admin/base')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Data Mahasiswa</h4>
                  <p class="card-description">
                  </p>
                  <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="post" accept-charset="utf-8">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                      <label>NIM</label>
                      <input type="nim" class="form-control" name="nim" id="nim" value="{{ $mahasiswa->nim }}"aria-label="NIM">
                    </div>
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" id="name" value="{{ $mahasiswa->name }}" aria-label="Nama">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $mahasiswa->email }}" aria-label="Email">
                  </div>
                   <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ $mahasiswa->tempat_lahir }}"  aria-label="tempat_lahir">
                  </div>
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" value="{{ $mahasiswa->tanggal_lahir }}"  aria-label="Email">
                  </div>
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect2">Jenis Kelamin</label>
                      <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" id="exampleFormControlSelect2">
                        @if($mahasiswa->jenis_kelamin == 1)
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="{{ $mahasiswa->jenis_kelamin }}" selected>Laki-Laki</option>
                          <option value="2">Perempuan</option>
                        @elseif($mahasiswa->jenis_kelamin == 2)
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="1">Laki-Laki</option>
                          <option value="{{ $mahasiswa->jenis_kelamin }}" selected>Perempuan</option>
                        @else
                          <option value="">Pilih Jenis Kelamin</option>
                          <option value="1">Laki-Laki</option>
                          <option value="2">Perempuan</option>
                        @endif
                      </select>
                    </div>
                  <div class="form-group">
                    <label>Agama</label>
                    <input type="text" class="form-control" name="agama" id="agama" value="{{ $mahasiswa->agama_mhs }}" aria-label="Agama">
                  </div>
                   <div class="form-group">
                      <label for="exampleTextarea1">Alamat</label>
                      <textarea class="form-control" name="alamat" id="alamat" value="{{ $mahasiswa->alamat_mhs }}"id="exampleTextarea1" rows="2"></textarea>
                    </div>
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                      <label for="exampleFormControlSelect2">Status</label>
                      <select name="status" id="status" class="form-control" id="exampleFormControlSelect2">
                        @if($mahasiswa->status == 1)
                          <option value="">Pilih Status</option>
                          <option value="{{ $mahasiswa->status }}" selected>Aktif
                          </option>
                          <option value="2">Tidak Aktif</option>
                        @elseif($mahasiswa->status == 2)
                          <option value="">Pilih Status</option>
                          <option value="1">Aktif</option>
                          <option value="{{ $mahasiswa->status }}" selected>Tidak Aktif</option>
                        @else
                          <option value="">Pilih Status</option>
                          <option value="1">Aktif</option>
                          <option value="2" selected>Tidak Aktif</option>
                        @endif
                      </select>
                    </div>
                  <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control"  name="nik" id="nik" value="{{ $mahasiswa->nik }}" placeholder="NIK" aria-label="NIK">
                  </div>
                <button type="submit" class="btn btn-success mr-2">Update</button>
              </div>
            </div>
@endsection