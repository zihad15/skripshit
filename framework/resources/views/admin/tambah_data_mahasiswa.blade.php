@extends('admin/base')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Data Mahasiswa</h4>
                  <p class="card-description">
                    
                  </p>
                  <form method="POST" action="{{ route('mahasiswa.store') }}">
                    @csrf
                    <div class="form-group">
                      <label>NIM</label>
                      <input type="text" name="nim" id="nim" class="form-control" placeholder="NIM" aria-label="Username">
                    </div>
                    <div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" name="nama_mahasiswa" id="nama_mahasiswa" class="form-control" placeholder="Nama Lengkap" aria-label="Nama">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" name="email" id="email" class="form-control" placeholder="Email" aria-label="Email">
                    </div>
                     <div class="form-group">
                      <label>Tempat Lahir</label>
                      <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir" aria-label="Email">
                    </div>
                    <div class="form-group">
                      <label>Tanggal Lahir</label>
                      <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" placeholder="tttt/bb/dd" aria-label="Email">
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect2">Jenis Kelamin</label>
                      <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                        <option value="1">Laki-Laki</option>
                        <option value="2">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Agama</label>
                      <input type="text" name="agama_mhs" id="agama_mhs" class="form-control" placeholder="Agama" aria-label="Agama">
                    </div>
                     <div class="form-group">
                        <label for="exampleTextarea1">Alamat</label>
                        <textarea class="form-control" name="alamat_mhs" id="alamat_mhs" rows="2"></textarea>
                      </div>

                    <div class="form-group">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect2">Status</label>
                      <select class="form-control" name="status" id="status">
                        <option value="1">Aktif</option>
                        <option value="2">Tidak Aktif</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>NIK</label>
                      <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK" aria-label="NIK">
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                  </form>
              </div>
            </div>
@endsection