@extends('layouts.app_base')
@section('css')
  <!-- DataTables -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- jQuery Modal -->
  <script type="text/javascript" src="{!! asset('assets/custom/modal.min.js') !!}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-2">
              <h4 class="card-title">Table Permohonan</h4>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
              <input type="text" name="dates" id="dates" class="form-control">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
              @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 1)
                @if(Auth::user()->status_mahasiswa != 2)
                  <a href="{{ route('permohonan.create') }}" class="btn btn-md btn-success card-title">+ Tambah Permohonan</a>
                @endif
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
                  <th>Prodi</th>
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
                  <td>
                    @php($prodi = App\Prodi::find($v->prodi_id))
                    {{ $prodi->nama_prodi }}
                  </td>
                  <td>{{ $v->nama_surat }}</td>
                  <td>
                    @if($v->prasyarat == 1)
                      Permohonan Memiliki Prasyarat Silahkan Tinjau/Edit <a href="#prasyarat-{{ $v->surat_id }}" rel="modal:open">disini.</a>
                    @elseif($v->prasyarat == 2)
                       Permohonan Memiliki Catatan Surat Silahkan Tinjau/Edit <a href="#catatan-{{ $v->surat_id }}" rel="modal:open">disini.</a>
                    @elseif($v->prasyarat == 3)
                       Permohonan Memiliki Prasyarat Surat Silahkan Tinjau/Edit <a href="#prasyarat-{{ $v->surat_id }}" rel="modal:open">disini.</a>
                    @else
                      Permohonan Tidak Memiliki Prasyarat.
                    @endif
                  </td>
                  <td>{{ $v->catatan }}</td>
                  <td>
                    @php($surat = App\Surat::find($v->surat_id))
                    @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN'))
                      <p style="text-align: center; color: white;" class="btn-sm btn-warning">{{ $v->status }}</p>
                    @elseif($v->status == Config::get('constants.PERMOHONAN_DITOLAK_KEPALA_AKADEMIK'))
                      <p style="text-align: center;" class="btn-sm btn-danger">{{ $v->status }}</p>
                    @elseif($v->status == Config::get('constants.PERMOHONAN_DISETUJUI_KEPALA_AKADEMIK'))
                      <p style="text-align: center;" class="btn-sm btn-success">{{ $v->status }}</p>
                    @endif
                  </td>
                  <td>{{ $v->updated_at }}</td>
                  <td>
                    @php($surat = App\Surat::find($v->surat_id))
                    @if($v->status == Config::get('constants.PERMOHONAN_DISETUJUI_KEPALA_AKADEMIK'))
                      @if(Auth::user()->role_id == 4 
                      && $surat->code == "KET-AAK02"
                      || $surat->nama_surat == "KRS" 
                      || $surat->nama_surat == "Transkrip")

                      @else
                        @if(Auth::user()->status_mahasiswa != 2)
                          <form action="{{ url('permohonan/downloadPDF') }}" method="GET" style="white-space: nowrap;">
                            @csrf
                            <input type="number" name="surat_id" value="{{ $v->surat_id }}" hidden>
                            <input type="number" name="user_id" value="{{ $v->user_id }}" hidden>
                            <button class="btn btn-sm btn-success">Download Surat</button>
                          </form>
                        @endif
                      @endif
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
                      @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                      && Auth::user()->role_id == 2)
                          <a href="#penolakan-{{ $v->surat_id }}" rel="modal:open" class="btn btn-sm btn-danger">Tolak</a>
                          <a href="{{ url('permohonan/terima', $v->id) }}" class="btn btn-sm btn-success" onclick="return confirm('Anda yakin?');">Terima</a>
                      @endif
                    </td>
                  @endif
                </tr>
                <!-- MODAL PRASYARAT -->
                <div id="prasyarat-{{ $v->surat_id }}" class="modal">
                  @php($surat = App\Surat::find($v->surat_id))
                  @php($prasyarat = App\Prasyarat::find($surat->prasyarat_id))
                  @if($surat->code == "KET-AAK02")
                    <form method="POST" action="{{ url('permohonan/updatePratinjau') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group">
                        @if ($errors->any())
                          <div class="alert alert-danger">
                            <button data-dismiss="alert" class="close"></button>
                              {!! implode('', $errors->all('<p>:message</p>')) !!}
                          </div>
                        @endif
                        <div id="prasyarat" style="margin-top: 10%;">
                          <h5>Prasyarat</h5>
                          <hr>
                          <input type="number" name="prasyarat_id" value="{{ $prasyarat->id }}" hidden>
                          <input type="number" name="permohonan_id" value="{{ $v->id }}" hidden>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Surat Keterangan Persetujuan Sidang</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->surat_keterangan_persetujuan_sidang) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->surat_keterangan_persetujuan_sidang) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="surat_keterangan_persetujuan_sidang" id="surat_keterangan_persetujuan_sidang" accept="image/*" onchange="readURL(this);" class="form-control"/>
                                    @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Berita Acara Bimbingan</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->berita_acara_bimbingan) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->berita_acara_bimbingan) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="berita_acara_bimbingan" id="berita_acara_bimbingan" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Surat Tugas Bimbingan</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->surat_tugas_bimbingan) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->surat_tugas_bimbingan) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="surat_tugas_bimbingan" id="surat_tugas_bimbingan" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">KRS</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->krs) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->krs) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="krs" id="krs" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Ijazah SMU/D3</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->ijazah) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->ijazah) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="ijazah" id="ijazah" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">AK01</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->ak01) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->ak01) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="ak01" id="ak01" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Transkrip Nilai</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->transkrip_nilai) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->transkrip_nilai) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="transkrip_nilai" id="transkrip_nilai" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Penilaian Proposal</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->penilaian_proposal) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->penilaian_proposal) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="penilaian_proposal" id="penilaian_proposal" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Data Diri</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->data_diri) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->data_diri) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="data_diri" id="data_diri" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Pas Foto 3 x 4</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->pasfoto_3x4) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->pasfoto_3x4) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="pasfoto_3x4" id="pasfoto_3x4" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Pas Foto 4 x 6</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->pasfoto_4x6) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->pasfoto_4x6) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="pasfoto_4x6" id="pasfoto_4x6" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="">Foto Copy KTP</label><br>
                                <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$prasyarat->foto_copy_ktp) }}">
                                  <img src="{{ url('framework/storage/app/public/images/'.$prasyarat->foto_copy_ktp) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                                </a>
                                @if(Auth::user()->role_id == 4)
                                  @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                                  || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                                    <input type='file' name="foto_copy_ktp" id="foto_copy_ktp" accept="image/*" onchange="readURL(this);" class="form-control" />
                                  @endif
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @if(Auth::user()->role_id == 4)
                        @if($v->status == Config::get('constants.PERMOHONAN_BERHASIL_DIAJUKAN') 
                        || $v->status == Config::get('constants.PERMOHONAN_DITOLAK_PETUGAS_AKADEMIK'))
                          <button type="submit" class="btn btn-success mr-2">Update Prasyarat</button>
                        @endif
                      @endif
                    </form>
                  @else
                    <form method="POST" action="{{ url('permohonan/updatePratinjau') }}" enctype="multipart/form-data">
                      @csrf
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
                            <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$surat->bukti_tf) }}">
                              <img src="{{ url('framework/storage/app/public/images/'.$surat->bukti_tf) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                            </a>
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
                              <a target="_blank" href="{{ url('framework/storage/app/public/images/'.$surat->cover_proposal) }}">
                                <img src="{{ url('framework/storage/app/public/images/'.$surat->cover_proposal) }}" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;">
                              </a>
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
                  @endif
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


                <!-- MODAL INFORMASI -->
                <div class="modal" id="modal_notif_ak02">
                  <label>INFORMASI!</label>
                  <p style="color: red;">Anda memiliki pengajuan permohonan Surat Keterangan Ak02, Silahkan kumpulkan hardcopy Proposal ke bagian akademik sejumlah dosen penguji untuk proses lebih lanjut.</p>
                </div>
                <!-- END MODAL INFORMASI -->
                <a href="#modal_notif_ak02" rel="modal:open" id="ak02CheckButton" style="display: none;"></a>

                <!-- MODAL INFORMASI -->
                <div class="modal" id="modal_notif_flexsm">
                  <label>PERHATIAN!</label>
                  @if(Auth::user()->flex_sm == 1)
                    <p style="color: red;">Status Kemahasiswaan Anda adalah Tidak Aktif, Pengajuan pengaktifan Status Mahasiswa sedang dalam proses.</p>
                  @else
                    <p style="color: red;">Status Kemahasiswaan Anda adalah Tidak Aktif silahkan <a href="{{ url('users/requestFlexsm') }}" onclick="return confirm('Anda yakin ingin mengajukan pengaktifan Status Mahasiswa?');">klik dsini</a> untuk mengajukan pengaktifan Status Mahasiswa.</p>
                  @endif
                </div>
                <!-- END MODAL INFORMASI -->
                <a href="#modal_notif_flexsm" rel="modal:open" id="flexsmCheckButton" style="display: none;"></a>
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
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script type="text/javascript">
    var table;
    $(document).ready( function () {
      table = $('#datatables').DataTable({
         aaSorting: [[0, 'desc']],
      });
    }); 
  </script>
  <script type="text/javascript">
    var d = new Date();
    var months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December"
    ];

    var monthsnumber = [
      "01",
      "02",
      "03",
      "04",
      "05",
      "06",
      "07",
      "08",
      "09",
      "10",
      "11",
      "12"
    ];

    var today = d.getDate()+"/"+months[d.getMonth()]+"/"+d.getFullYear();

    var d7 = new Date(Date.now()-30*24*60*60*1000);
    var yesterday = d7.getDate()+"/"+months[d7.getMonth()]+"/"+d7.getFullYear();

    var sdate = d7.getFullYear()+"-"+monthsnumber[d7.getMonth()]+"-"+d7.getDate();
    var edate = d.getFullYear()+"-"+monthsnumber[d.getMonth()]+"-"+d.getDate();

    var arrDate = [];
    $('input[name="dates"]').daterangepicker({
      opens: 'left',
      startDate: yesterday,
      endDate: today,
      locale: {
        format: 'D/MMMM/YYYY'
      }, 
    }, function(start, end, label) {
      sdate = start.format('YYYY-MM-DD');
      edate = end.format('YYYY-MM-DD');

      $.fn.dataTableExt.afnFiltering.push(
        function( settings, data, dataIndex ) {
            var d = new Date(data[0]);
            var date = d.getFullYear()+"-"+monthsnumber[d.getMonth()]+"-"+d.getDate();
            if (sdate <= date   && date <= edate )
            {
                return true;
            }
            return false;
        }
      );
      table.draw();
    });
  </script>
  <script>
    
  </script>
  <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).parent().children("a").children("img").show()
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
  </script>
  <script type="text/javascript">
    var baseUrl = "{{ url('/') }}";
    $.ajax({
      type: "GET",
      url: baseUrl+"/permohonan/ak02Check/",
      success: function(response){
        if (response > 0) {
          $('#ak02CheckButton')[0].click();
        }
      }
    });   
  </script>
  <script type="text/javascript">
    var baseUrl = "{{ url('/') }}";
    $.ajax({
      type: "GET",
      url: baseUrl+"/users/statusMahasiswaCheck/",
      success: function(response){
        if (response > 0) {
          $('#flexsmCheckButton')[0].click();
        }
      }
    });   
  </script>
@endsection