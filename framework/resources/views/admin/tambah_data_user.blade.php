@extends('admin/base')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Tambah Data User</h4>
                  <p class="card-description">
                  </p>
                  <form action="{{ route('data_user.store') }}" method="post" accept-charset="utf-8">
                    @csrf
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name" aria-label="Name">
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username" aria-label="Username">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" aria-label="Email">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Username">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect2">Role</label>
                      <select name="role_id" id="role_id" class="form-control" id="exampleFormControlSelect2">
                        <option value="">Pilih Role</option>
                        @foreach($roles as $data)
                          <option value="{{ $data->id }}">{{ $data->role_name }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect2">Status</label>
                      <select name="status" id="status" class="form-control" id="exampleFormControlSelect2">
                        <option value="">Pilih Status</option>
                        <option value="1">Aktif</option>
                        <option value="2">Tidak Aktif</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a href="{{ route('data_user.index') }}" class="btn btn-danger" title="">Cancel</a>
                  </form>
                </div>
            </div>
@endsection