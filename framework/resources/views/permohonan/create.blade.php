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
              <input type='file' name="bukti_tf" id="bukti_tf" onchange="readURL(this);" class="form-control" />
            </div>
            <div class="form-group" id="divcoverproposal">
              <label for="">Cover Proposal</label><br>
              <img src="" alt="" style="width: 100px;height: 100px;margin-bottom: 10px;display: none;">
              <input type='file' name="cover_proposal" id="cover_proposal" onchange="readURL(this);" class="form-control" />
            </div>
          </div>
          <div id="divcatatan" style="display: none;">
            <br>
            <label>Catatan</label>
            <br>
            <label style="color: red;">Isi catatan dengan alasan cuti (Jika CUTI),</label>
            <br>
            <label style="color: red;">Nama perusahaan/institusi, dan alamat (Jika Riset/Magang)</label>
            <div class="form-group">
              <textarea class="form-control" name="catatan_surat" id="catatan_surat" placeholder="Tolong isi catatan sesuai dengan alasan cuti (Jika CUTI), atau Nama dan alamat (Jika Riset/Magang)" style="height: 150px"></textarea>
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
        document.getElementById('prasyarat').style.display = 'block';
        document.getElementById('divcoverproposal').style.display = 'block';
        document.getElementById('bukti_tf').required = true;
        document.getElementById('cover_proposal').required = true;

        document.getElementById('divcatatan').style.display = 'none';
        document.getElementById('catatan_surat').required = false;
      } else if(e.value == "KRS" || e.value == "TRANSKRIP") {
        document.getElementById('prasyarat').style.display = 'block';
        document.getElementById('bukti_tf').required = true;
        document.getElementById('divcoverproposal').style.display = 'none';
        document.getElementById('cover_proposal').required = false;

        document.getElementById('divcatatan').style.display = 'none';
        document.getElementById('catatan_surat').required = false;
      } else if(e.value == "KET_MAGANG" || e.value == "KET_CUTI") {
        document.getElementById('divcatatan').style.display = 'block';
        document.getElementById('catatan_surat').required = true;

        document.getElementById('prasyarat').style.display = 'none';
        document.getElementById('bukti_tf').required = false;
        document.getElementById('cover_proposal').required = false;
      } else {
        document.getElementById('divcatatan').style.display = 'none';
        document.getElementById('catatan_surat').required = false;

        document.getElementById('prasyarat').style.display = 'none';
        document.getElementById('bukti_tf').required = false;
        document.getElementById('cover_proposal').required = false;
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