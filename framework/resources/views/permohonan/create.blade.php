@extends('layouts.app_base')
@section('content')
@section('css')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection
@if ($errors->any())
  <div class="alert alert-danger">
    <button data-dismiss="alert" class="close"></button>
      {!! implode('', $errors->all('<p>:message</p>')) !!}
  </div>
@endif
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Form Tambah Permohonan</h4>
      <p class="card-description">
        
      </p>
      <form method="POST" action="{{ route('permohonan.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="exampleFormControlSelect2">Nama Surat</label>
          <select class="form-control" name="cons" id="cons" onchange="showDiv(this)">
            @php($cons = Config::get('constants.SURAT_CONS'))
            <option value="">Pilih nama surat yang ingin di ajukan.</option>
            <option value="{{ $cons['0'] }}">KRS</option>
            <option value="{{ $cons['1'] }}">Transkrip</option>
            <option value="{{ $cons['2'] }}">Surat Keterangan Aktif</option>
            <option value="{{ $cons['3'] }}">Surat Riset/Magang</option>
            <option value="{{ $cons['4'] }}">Surat Cuti</option>
            <option value="{{ $cons['5'] }}">Surat AK-01</option>
            <option value="{{ $cons['6'] }}">Surat AK-02</option>
          </select>
          <div id="prasyarat" style="display: none;">
            <br>
            <h5>Prasyarat</h5>
            <hr>
            <div class="form-group">
              <label for="">Bukti TF</label><br>
              <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
              <input type='file' name="bukti_tf" id="bukti_tf" accept="image/*" onchange="readURL(this);" class="form-control" />
            </div>
            <div class="form-group" id="divcoverproposal">
              <label for="">Cover Proposal</label><br>
              <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
              <input type='file' name="cover_proposal" id="cover_proposal" accept="image/*" onchange="readURL(this);" class="form-control" />
            </div>
          </div>
          <div id="divcuti" style="display: none;">
            <br>
            <label>Catatan</label>
            <label style="color: red; font-size: 10px;">Isi dengan alasan anda mengambil cuti.</label>
            <div class="form-group">
              <textarea class="form-control" name="catatan_cuti" id="catatan_cuti" placeholder="Isi dengan alasan anda mengambil cuti." style="height: 150px"></textarea>
            </div>
            <div class="form-group">
              <label for="">Bukti TF</label><br>
              <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
              <input type='file' name="bukti_tf_cuti" id="bukti_tf_cuti" accept="image/*" onchange="readURL(this);" class="form-control" />
            </div>
          </div>
          <div id="divmagang" style="display: none;">
            <br>
            <div style="white-space: nowrap;">
              <label>Catatan</label>
              <label style="color: red; font-size: 10px;">Isi dengan nama perusahaan/institusi, dan alamat tempat anda riset/magang.</label>
            </div>
            <div class="form-group">
              <textarea class="form-control" name="catatan_magang" id="catatan_magang" placeholder="Isi dengan nama perusahaan/institusi, dan alamat tempat anda riset/magang." style="height: 150px"></textarea>
            </div>
          </div>
          <div id="prasyarat_ak02" style="display: none;">
            <br>
            <h5>Prasyarat</h5>
            <hr>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Surat Keterangan Persetujuan Sidang</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="surat_keterangan_persetujuan_sidang" id="surat_keterangan_persetujuan_sidang" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Berita Acara Bimbingan</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="berita_acara_bimbingan" id="berita_acara_bimbingan" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Surat Tugas Bimbingan</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="surat_tugas_bimbingan" id="surat_tugas_bimbingan" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">KRS</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="krs" id="krs" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Ijazah SMU/D3</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="ijazah" id="ijazah" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">AK01</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="ak01" id="ak01" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Transkrip Nilai</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="transkrip_nilai" id="transkrip_nilai" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Penilaian Proposal</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="penilaian_proposal" id="penilaian_proposal" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Data Diri</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="data_diri" id="data_diri" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Pas Foto 3 x 4</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="pasfoto_3x4" id="pasfoto_3x4" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Pas Foto 4 x 6</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="pasfoto_4x6" id="pasfoto_4x6" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="">Foto Copy KTP</label><br>
                  <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
                  <input type='file' name="foto_copy_ktp" id="foto_copy_ktp" accept="image/*" onchange="readURL(this);" class="form-control" />
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-success mr-2">Submit</button>
      </form>
  </div>
</div>
@endsection
@section('js')
  <script type="text/javascript">
    function showDiv(e)
    {
      if (e.value == "KET_AK01") {
        document.getElementById('prasyarat').style.display        = 'block';
        document.getElementById('divcoverproposal').style.display = 'block';
        document.getElementById('bukti_tf').required              = true;
        document.getElementById('cover_proposal').required        = true;

        document.getElementById('divcuti').style.display   = 'none';
        document.getElementById('divmagang').style.display = 'none';
        document.getElementById('catatan_cuti').required   = false;
        document.getElementById('catatan_magang').required = false;
        document.getElementById('bukti_tf_cuti').required  = false;

        document.getElementById('prasyarat_ak02').style.display = 'none';
        document.getElementById('surat_keterangan_persetujuan_sidang').required = false;
        document.getElementById('ijazah').required                              = false;
        document.getElementById('transkrip_nilai').required                     = false;
        document.getElementById('krs').required                                 = false;
        document.getElementById('berita_acara_bimbingan').required              = false;
        document.getElementById('ak01').required                                = false;
        document.getElementById('surat_tugas_bimbingan').required               = false;
        document.getElementById('penilaian_proposal').required                  = false;
        document.getElementById('data_diri').required                           = false;
        document.getElementById('pasfoto_3x4').required                         = false;
        document.getElementById('pasfoto_4x6').required                         = false;
        document.getElementById('foto_copy_ktp').required                       = false;
      } else if(e.value == "KET_AK02") {
        document.getElementById('prasyarat_ak02').style.display                 = 'block';
        document.getElementById('surat_keterangan_persetujuan_sidang').required = true;
        document.getElementById('ijazah').required                              = true;
        document.getElementById('transkrip_nilai').required                     = true;
        document.getElementById('krs').required                                 = true;
        document.getElementById('berita_acara_bimbingan').required              = true;
        document.getElementById('ak01').required                                = true;
        document.getElementById('surat_tugas_bimbingan').required               = true;
        document.getElementById('penilaian_proposal').required                  = true;
        document.getElementById('data_diri').required                           = true;
        document.getElementById('pasfoto_3x4').required                         = true;
        document.getElementById('pasfoto_4x6').required                         = true;
        document.getElementById('foto_copy_ktp').required                       = true;

        document.getElementById('prasyarat').style.display = 'none';
        document.getElementById('bukti_tf').required       = false;
        document.getElementById('cover_proposal').required = false;

        document.getElementById('divcuti').style.display   = 'none';
        document.getElementById('divmagang').style.display = 'none';
        document.getElementById('catatan_cuti').required   = false;
        document.getElementById('catatan_magang').required = false;
        document.getElementById('bukti_tf_cuti').required  = false;
      } else if(e.value == "KRS" || e.value == "TRANSKRIP") {
        document.getElementById('prasyarat').style.display        = 'block';
        document.getElementById('bukti_tf').required              = true;
        document.getElementById('divcoverproposal').style.display = 'none';
        document.getElementById('cover_proposal').required        = false;

        document.getElementById('divcuti').style.display   = 'none';
        document.getElementById('divmagang').style.display = 'none';
        document.getElementById('catatan_cuti').required   = false;
        document.getElementById('catatan_magang').required = false;
        document.getElementById('bukti_tf_cuti').required  = false;

        document.getElementById('prasyarat_ak02').style.display = 'none';
        document.getElementById('surat_keterangan_persetujuan_sidang').required = false;
        document.getElementById('ijazah').required                              = false;
        document.getElementById('transkrip_nilai').required                     = false;
        document.getElementById('krs').required                                 = false;
        document.getElementById('berita_acara_bimbingan').required              = false;
        document.getElementById('ak01').required                                = false;
        document.getElementById('surat_tugas_bimbingan').required               = false;
        document.getElementById('penilaian_proposal').required                  = false;
        document.getElementById('data_diri').required                           = false;
        document.getElementById('pasfoto_3x4').required                         = false;
        document.getElementById('pasfoto_4x6').required                         = false;
        document.getElementById('foto_copy_ktp').required                       = false;
      } else if(e.value == "KET_MAGANG") {
        document.getElementById('divmagang').style.display  = 'block';
        document.getElementById('catatan_magang').required  = true;
        document.getElementById('divcuti').style.display    = 'none';
        document.getElementById('catatan_cuti').required    = false;
        document.getElementById('bukti_tf_cuti').required   = false;

        document.getElementById('prasyarat').style.display = 'none';
        document.getElementById('bukti_tf').required       = false;
        document.getElementById('cover_proposal').required = false;

        document.getElementById('prasyarat_ak02').style.display = 'none';
        document.getElementById('surat_keterangan_persetujuan_sidang').required = false;
        document.getElementById('ijazah').required                              = false;
        document.getElementById('transkrip_nilai').required                     = false;
        document.getElementById('krs').required                                 = false;
        document.getElementById('berita_acara_bimbingan').required              = false;
        document.getElementById('ak01').required                                = false;
        document.getElementById('surat_tugas_bimbingan').required               = false;
        document.getElementById('penilaian_proposal').required                  = false;
        document.getElementById('data_diri').required                           = false;
        document.getElementById('pasfoto_3x4').required                         = false;
        document.getElementById('pasfoto_4x6').required                         = false;
        document.getElementById('foto_copy_ktp').required                       = false;
      } else if(e.value == "KET_CUTI") {
        document.getElementById('divcuti').style.display   = 'block';
        document.getElementById('catatan_cuti').required   = true;
        document.getElementById('bukti_tf_cuti').required = true;
        document.getElementById('divmagang').style.display = 'none';
        document.getElementById('catatan_magang').required = false;

        document.getElementById('prasyarat').style.display = 'none';
        document.getElementById('bukti_tf').required       = false;
        document.getElementById('cover_proposal').required = false;

        document.getElementById('prasyarat_ak02').style.display = 'none';
        document.getElementById('surat_keterangan_persetujuan_sidang').required = false;
        document.getElementById('ijazah').required                              = false;
        document.getElementById('transkrip_nilai').required                     = false;
        document.getElementById('krs').required                                 = false;
        document.getElementById('berita_acara_bimbingan').required              = false;
        document.getElementById('ak01').required                                = false;
        document.getElementById('surat_tugas_bimbingan').required               = false;
        document.getElementById('penilaian_proposal').required                  = false;
        document.getElementById('data_diri').required                           = false;
        document.getElementById('pasfoto_3x4').required                         = false;
        document.getElementById('pasfoto_4x6').required                         = false;
        document.getElementById('foto_copy_ktp').required                       = false;
      } else {
        document.getElementById('divcuti').style.display   = 'none';
        document.getElementById('divmagang').style.display = 'none';
        document.getElementById('catatan_cuti').required   = false;
        document.getElementById('catatan_magang').required = false;
        document.getElementById('bukti_tf_cuti').required  = false;

        document.getElementById('prasyarat').style.display = 'none';
        document.getElementById('bukti_tf').required       = false;
        document.getElementById('cover_proposal').required = false;

        document.getElementById('prasyarat_ak02').style.display = 'none';
        document.getElementById('surat_keterangan_persetujuan_sidang').required = false;
        document.getElementById('ijazah').required                              = false;
        document.getElementById('transkrip_nilai').required                     = false;
        document.getElementById('krs').required                                 = false;
        document.getElementById('berita_acara_bimbingan').required              = false;
        document.getElementById('ak01').required                                = false;
        document.getElementById('surat_tugas_bimbingan').required               = false;
        document.getElementById('penilaian_proposal').required                  = false;
        document.getElementById('data_diri').required                           = false;
        document.getElementById('pasfoto_3x4').required                         = false;
        document.getElementById('pasfoto_4x6').required                         = false;
        document.getElementById('foto_copy_ktp').required                       = false;
      }
    }
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