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
              <h4 class="card-title">Permohonan Anda</h4>
            </div>
            <div class="col-md-7"></div>
            <div class="col-md-2">
              <a href="{{ route('prodi.create') }}" class="btn btn-md btn-success card-title">+ Tambah Prodi</a>
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
                  <th>Kode Prodi</th>
                  <th>Nama Prodi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($prodi as $v)
              	<tr>
              		<td>{{ $v->kode_prodi }}</td>
              		<td>{{ $v->nama_prodi }}</td>
                  <td>
                    <form action="{{ url('prodi/destroy') }}" method="POST">
                      @csrf
                      <input type="number" name="prodi_id" value="{{ $v->id }}" style="display: none;">
                      <a href="{{ url('prodi/edit', $v->id) }}" class="btn btn-md btn-primary">Edit</a>
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