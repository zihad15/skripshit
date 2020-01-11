@extends('admin/base')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Ubah Data Profil</h4>
                  <p class="card-description">
                    
                  </p>
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" placeholder="Nama Lengkap" aria-label="Username">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" placeholder="Email" aria-label="Email">
                  </div>
                  <div class="form-group">
                    <label>NIP</label>
                    <input type="text" class="form-control" placeholder="NIP" aria-label="Email">
                  </div>
                  <div class="form-group">
                  </div>
                  <div class="form-group">
                  <div class="form-group">
                      <label for="exampleTextarea1">Alamat</label>
                      <textarea class="form-control" id="exampleTextarea1" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                    <label for="exampleFormControlSelect2">Jenis Kelamin</label>
                    <select class="form-control" id="exampleFormControlSelect2">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                    </select>
                  </div>
                  <div class="form-group">
                  </div>
                <button type="submit" class="btn btn-success mr-2">Ubah</button>
              </div>
            </div>
@endsection