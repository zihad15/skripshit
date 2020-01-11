@extends('admin/base')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Data User</h4>
                  <p class="card-description">
                  </p>
                  <form action="{{ route('data_user.update', $user->id) }}" method="post" accept-charset="utf-8">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{ $user->name }}" aria-label="Name">
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" aria-label="Username">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" aria-label="Email">
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlSelect2">Status</label>
                      <select name="status" id="status" class="form-control" id="exampleFormControlSelect2">
                        @if($user->status == 1)
                          <option value="">Pilih Status</option>
                          <option value="{{ $user->status }}" selected>Aktif</option>
                          <option value="2">Tidak Aktif</option>
                        @elseif($user->status == 2)
                          <option value="">Pilih Status</option>
                          <option value="1">Aktif</option>
                          <option value="{{ $user->status }}" selected>Tidak Aktif</option>
                          <option value="3">3</option>
                        @else
                          <option value="">Pilih Status</option>
                          <option value="1">Aktif</option>
                          <option value="2">Tidak Aktif</option>
                        @endif
                      </select>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Update</button>
                    <a href="{{ route('data_user.index') }}" class="btn btn-danger" title="">Cancel</a>
                  </form>
                </div>
            </div>
@endsection