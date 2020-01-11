@extends('admin/base')
@section('content')
<div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  @if (session('alert-success'))
                    <div class="alert alert-success">
                        {{ session('alert-success') }}
                    </div>
                  @elseif (session('alert-delete'))
                    <div class="alert alert-danger">
                        {{ session('alert-delete') }}
                    </div>
                  @endif
                  <h4 class="card-title">Data SDM</h4>
                  <h4></h4>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                            NIP
                          </th>
                          <th>
                            Nama
                          </th>
                          <th>
                            Username
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Role SDM
                          </th>
                          <th>
                            Alamat
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Aksi
                          </th>

                        </tr>
                        
                        </tr>
                      </thead>
                      <tbody>
                        @php $no = 1 @endphp
                        @foreach($sdm as $data)
                          <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data->nip }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->username }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->role_name }}</td>
                            <td>{{ $data->alamat }}</td>
                            <td>
                              @if($data->status ==1)
                                Aktif
                              @else
                                Tidak Aktif
                              @endif
                            </td>
                            <td>
                              <form action="{{ route('sdm.destroy', $data->id ) }}" method="POST">
                                  @csrf
                                  {{ method_field('DELETE') }}
                              <a  class="btn btn-sm btn-primary" href="{{ route('sdm.edit', $data->id) }}" title="">Edit</a>
                              <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau menghapus aku?')">Delete</button>
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