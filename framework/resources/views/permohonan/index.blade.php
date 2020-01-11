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
              @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1)
                <a href="{{ route('permohonan.create') }}" class="btn btn-md btn-success card-title">+ Tambah Permohonan</a>
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
                  <th>Tanggal Permohonan</th>
                  <th>Nama Mahasiswa</th>
                  <th>Nama Surat</th>
                  <th>Prasyarat</th>
                  <th>Catatan</th>
                  <th>Status</th>
                  <th>Tanggal Update</th>
                  <th>Surat</th>
                  @if(Auth::user()->role_id != 4)
                    <th>Aksi</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                @foreach($permohonan as $v)
                <tr>
                  <td>{{ $v->created_at }}</td>
                  <td>{{ $v->name }}</td>
                  <td>{{ $v->nama_surat }}</td>
                  <td>
                    @if($v->prasyarat == 0)
                      Permohonan Tidak Memiliki Prasyarat.
                    @elseif($v->prasyarat == 1)
                      Permohonan Memiliki Prasyarat Silahkan Tinjau/Edit <a href="#prasyarat-{{ $v->surat_id }}" rel="modal:open">disini.</a>
                    @else
                      Permohonan Memiliki Catatan Surat Silahkan Tinjau/Edit <a href="#catatan-{{ $v->surat_id }}" rel="modal:open">disini.</a>
                    @endif
                  </td>
                  <td>{{ $v->catatan }}</td>
                  <td>
                    @php($surat = App\Surat::find($v->surat_id))
                    @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN'))
                      <p style="text-align: center;" class="btn-sm btn-success">{{ $v->status }}</p>
                      <p class="btn-sm btn-warning" style="color: white;">
                        {{ Config::get('constants.MENUNGGU_PERSETUJUAN_PETUGAS_AKADEMIK') }}
                      </p>
                    @elseif($v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                      <p style="text-align: center;" class="btn-sm btn-danger">{{ $v->status }}</p>
                    @elseif($v->status == Config::get('constants.PERMOHONAN_DISETUJUI_PETUGAS_AKADEMIK'))
                      <p style="text-align: center;" class="btn-sm btn-success">{{ $v->status }}</p>
                      @if($surat->nama_surat != "KRS" 
                      && $surat->nama_surat != "Transkrip")
                        <p class="btn-sm btn-warning" style="color: white;">
                          {{ Config::get('constants.MENUNGGU_PERSETUJUAN_KEPALA_AKADEMIK') }}
                        </p>
                      @endif
                    @elseif($v->status == Config::get('constants.PERMOHONAN_DISETUJUI_KEPALA_AKADEMIK'))
                      <p style="text-align: center;" class="btn-sm btn-success">{{ $v->status }}</p>
                    @endif
                  </td>
                  <td>{{ $v->updated_at }}</td>
                  <td>
                    @php($surat = App\Surat::find($v->surat_id))
                    @if($v->status == Config::get('constants.PERMOHONAN_DISETUJUI_KEPALA_AKADEMIK'))
                      <form action="{{ url('permohonan/downloadPDF') }}" method="GET" style="white-space: nowrap;">
                        @csrf
                        <input type="number" name="surat_id" value="{{ $v->surat_id }}" hidden>
                        <input type="number" name="user_id" value="{{ $v->user_id }}" hidden>
                        <button class="btn btn-sm btn-success">Download Surat</button>
                      </form>
                    @elseif(Auth::user()->role_id != 4 
                    && $surat->nama_surat != "KRS" 
                    && $surat->nama_surat != "Transkrip")
                      <form action="{{ url('permohonan/surat') }}" method="GET" style="white-space: nowrap;" target="_blank">
                        @csrf
                        <input type="number" name="surat_id" value="{{ $v->surat_id }}" hidden>
                        <input type="number" name="user_id" value="{{ $v->user_id }}" hidden>
                        <button class="btn btn-sm btn-primary">Pratinjau Surat</button>
                      </form>
                    @endif
                  </td>
                  @if(Auth::user()->role_id != 4)
                    @php($surat = App\Surat::find($v->surat_id))
                    <td>
                      @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') && Auth::user()->role_id == 3 || Auth::user()->role_id == 1)
                          <a href="{{ url('permohonan/terima', $v->id) }}" class="btn btn-sm btn-success" onclick="return confirm('Anda yakin?');">Terima</a>
                          <a href="#penolakan-{{ $v->surat_id }}" rel="modal:open" class="btn btn-sm btn-danger">Tolak</a>
                      @endif
                      @if($v->status == Config::get('constants.PERMOHONAN_DISETUJUI_PETUGAS_AKADEMIK') 
                      && Auth::user()->role_id == 2 && $surat->nama_surat != "KRS" 
                      && $surat->nama_surat != "Transkrip")
                          <a href="{{ url('permohonan/terima', $v->id) }}" class="btn btn-sm btn-success" onclick="return confirm('Anda yakin?');">Terima</a>
                      @endif
                    </td>
                  @endif
                </tr>
                <!-- MODAL PRASYARAT -->
                <div id="prasyarat-{{ $v->surat_id }}" class="modal">
                  <form method="POST" action="{{ url('permohonan/updatePratinjau') }}" enctype="multipart/form-data">
                    @csrf
                    @php($surat = App\Surat::find($v->surat_id))
                    <div class="form-group">
                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <button data-dismiss="alert" class="close"></button>
                            {!! implode('', $errors->all('<p>:message</p>')) !!}
                        </div>
                      @endif
                      <div id="prasyarat">
                        <h5>Prasyarat</h5>
                        <hr>
                        <input type="number" name="surat_id" value="{{ $surat->id }}" hidden>
                        <input type="number" name="permohonan_id" value="{{ $v->id }}" hidden>
                        <div class="form-group">
                          <label for="">Bukti TF</label><br>
                          <img src="{{ url('framework/storage/app/public/images/'.$surat->bukti_tf) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                          <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$surat->bukti_tf) }}" class="btn btn-sm btn-primary"> perbesar</a>
                          @if(Auth::user()->role_id == 4)
                            @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                            || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                              <input type='file' name="bukti_tf" id="bukti_tf" onchange="readURL(this);" class="form-control"/>
                            @endif
                          @endif
                        </div>
                        @if(isset($surat->cover_proposal))
                          <div class="form-group">
                            <label for="">Cover Proposal</label><br>
                            <img src="{{ url('framework/storage/app/public/images/'.$surat->cover_proposal) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                            <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$surat->cover_proposal) }}" class="btn btn-sm btn-primary"> perbesar</a>
                            @if(Auth::user()->role_id == 4)
                              @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                              || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                <input type='file' name="cover_proposal" id="cover_proposal" onchange="readURL(this);" class="form-control"/>
                              @endif
                            @endif
                          </div>
                        @endif
                      </div>
                    </div>
                    @if(Auth::user()->role_id == 4)
                      @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                      || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                        <button type="submit" class="btn btn-success mr-2">Update Prasyarat</button>
                      @endif
                    @endif
                  </form>
                </div>
                <!-- END MODAL PRASYARAT -->

                <!-- MODAL CATATAN -->
                <div id="catatan-{{ $v->surat_id }}" class="modal">
                  <form method="POST" action="{{ url('permohonan/updateCatatan') }}">
                    @csrf
                    @php($surat = App\Surat::find($v->surat_id))
                    <div class="form-group">
                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <button data-dismiss="alert" class="close"></button>
                            {!! implode('', $errors->all('<p>:message</p>')) !!}
                        </div>
                      @endif
                      <div id="prasyarat">
                        <label>Catatan Surat</label>
                        <input type="number" name="id" value="{{ $surat->id }}" hidden>
                        <input type="number" name="permohonan_id" value="{{ $v->id }}" hidden>
                        <div class="form-group">
                          @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                          || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                            @if(Auth::user()->role_id == 4)
                              <textarea class="form-control" name="catatan_surat" id="catatan_surat" rows="10">{{ $surat->catatan_surat }}</textarea>
                            @else
                              <textarea class="form-control" name="catatan_surat" id="catatan_surat" rows="10" disabled>{{ $surat->catatan_surat }}</textarea>
                            @endif
                          @else
                            <textarea class="form-control" name="catatan_surat" id="catatan_surat" rows="10" disabled>{{ $surat->catatan_surat }}</textarea>
                          @endif
                        </div>
                      </div>
                    </div>
                    @if(Auth::user()->role_id == 4)
                      @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                      || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                        <button type="submit" class="btn btn-success mr-2">Update Catatan</button>
                      @endif
                    @endif
                  </form>
                </div>
                <!-- END MODAL CATATAN -->

                <!-- MODAL PENOLAKAN -->
                <div id="penolakan-{{ $v->surat_id }}" class="modal">
                  <form method="POST" action="{{ url('permohonan/tolak') }}">
                    @csrf
                    <div class="form-group">
                      @if ($errors->any())
                        <div class="alert alert-danger">
                          <button data-dismiss="alert" class="close"></button>
                            {!! implode('', $errors->all('<p>:message</p>')) !!}
                        </div>
                      @endif
                      <div id="prasyarat">
                        <label>Catatan Penolakan Permohonan</label>
                        <input type="number" name="id" value="{{ $v->id }}" hidden>
                        <div class="form-group">
                          <textarea class="form-control" name="catatan" id="catatan" rows="10" placeholder="Beritahu mahasiswa apa alasan penolakan anda." required></textarea>
                        </div>
                      </div>
                    </div>
                      <button type="submit" class="btn btn-success mr-2">Submit</button>
                  </form>
                </div>
                <!-- END MODAL PENOLAKAN -->
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
  <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).parent().children("img").show()
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
  </script>
@endsection