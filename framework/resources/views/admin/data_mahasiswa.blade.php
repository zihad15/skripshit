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
                  <h4 class="card-title">Mahasiswa</h4>
                  <h4></h4>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                        	<th>
                            No.
                          </th>
                          <th>
                            NIM
                          </th>
                          <th>
                            Nama Mahasiswa
                          </th>
                          <th>
                            Username
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Program Studi
                          </th>
                          <th>
                            Alamat
                          </th>
                          <th>
                            Jenis Kelamin
                          </th>
                          <th>
                            Agama
                          </th>
                          <th>
                            Tempat Lahir
                          </th>
                          <th>
                            Tanggal Lahir
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            NIK
                          </th>
                          <th>
                            Aksi
                          </th>
                        </tr>
                        
                        </tr>
                      </thead>
                      <tbody>
                        @php $no = 1 @endphp
                        @foreach($mahasiswa as $data)
                        <tr>
                          <td>
                            {{$no++}}
                          </td>
                          <td>{{$data->nim}}</td>
                          <td>{{$data->name}}</td>
                          <td>{{$data->username}}</td>
                          <td>{{$data->email}}</td>
                          <td></td>
                          <td>{{$data->alamat}}</td>
                          <td>{{$data->jenis_kelamin}}</td>
                          <td>{{$data->agama}}</td>
                          <td>{{$data->tempat_lahir}}</td>
                          <td>{{$data->tanggal_lahir}}</td>
                          <td>
                            @if($data->status ==1)
                              Aktif
                            @else
                              Tidak Aktif
                            @endif
                          </td>
                          <td>{{$data->nik}}</td>
                          <td>
                            <form action="{{ route('mahasiswa.destroy', $data->id ) }}" method="POST">
                                @csrf
                                {{ method_field('DELETE') }}
                            <a  class="btn btn-sm btn-primary" href="{{ route('mahasiswa.edit', $data->id) }}" title="">Edit</a>
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