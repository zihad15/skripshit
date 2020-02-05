@extends('layouts.app_base')
@section('css')
  <!-- DataTables -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- jQuery Modal -->
  <script type="text/javascript" src="{!! asset('assets/custom/modal.min.js') !!}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
@endsection
@section('content')
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-2">
              <h4 class="card-title">Data Mahasiswa</h4>
            </div>
            <div class="col-md-7"></div>
            <div class="col-md-2">
              @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1)
                <a href="{{ route('users.create') }}" class="btn btn-md btn-success card-title">+ Tambah User</a>
              @endif
            </div>
          </div>
          @if (session('alert'))
            <div class="alert alert-success">
                {{ session('alert') }}
            </div>
          @endif
          <div class="table-responsive">
            <table class="table table-bordered" id="datatables">
              <thead>
                <tr>
                  <th>Nama User</th>
                  <th>Role</th>
                  <th>Prodi</th>
                  <th>NIM/NIP</th>
                  <th>E-mail</th>
                  <th>No HP</th>
                  <th>Status</th>
                  <th>Status Mahasiswa</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($users as $v)
              	<tr>
              		<td>
                    @if($v->flex_sm == 1)
                    <span class="badge badge-pill badge-danger">
                      1
                    </span>
                    @endif
                    {{ $v->name }}
                  </td>
              		<td>{{ $v->role_name }}</td>
                  <td>
                    @if(isset($v->nama_prodi))
                      {{ $v->nama_prodi }}
                    @else
                      -
                    @endif
                  </td>
              		<td>{{ $v->nim_nip }}</td>
              		<td>{{ $v->email }}</td>
              		<td>{{ $v->no_hp }}</td>
              		<td>
                      @if($v->status == 1)
                        Aktif
                      @else 
                      Tidak Aktif
                      @endif
                  </td>
                  <td>
                      @if($v->status_mahasiswa == 1)
                        Aktif
                      @else 
                      Tidak Aktif
                      @endif
                  </td>
                  <td>
                    <form action="{{ url('users/destroy') }}" method="POST">
                      @csrf
                      <input type="number" name="user_id" value="{{ $v->id }}" style="display: none;">
                      <a href="{{ url('users/edit', $v->id) }}" class="btn btn-md btn-primary">Edit</a>
                      <button class="btn btn-md btn-danger" onclick="return confirm('Anda yakin?');">Delete</button>
                    </form>
                  </td>
              	</tr>
              	@endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script>
    $(document).ready( function () {
      $('#datatables').DataTable({
         aaSorting: [[0, 'desc']],
      });
    }); 
  </script>
@endsection