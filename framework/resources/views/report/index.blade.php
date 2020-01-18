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
          <form action="{{ url('report/exportData') }}" method="get" id="form-filter">
            <div class="row" style="margin-bottom: -1%;">
              <div class="col-md-4">
                <div class="form-group has-feedback">
                  <input type="text" name="overall_filter" id="overall_filter" class="form-control" placeholder="Filter Keseluruhan" onkeyup="reloadData()"> 
                  <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
              </div>
              <div class="col-md-4">
                 <input type="text" name="dates" id="dates" class="form-control">
                 <div id="exportdate">
                   <input type="text" name="sdate" value="default" style="display: none;">
                 </div>
              </div>
              <div class="col-md-2">
                <select class="form-control" name="filter_status" id="filter_status" onchange="reloadData()" style="width:100%">
                  <option value="">Filter Status</option>
                  @foreach(Config::get('constants.STATUS_PERMOHONAN') as $v)
                    <option value="{{ $v }}">{{ $v }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-2">
                <button class="btn btn-success" style="float: right;" name="btnSubmit">Export Excel</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-2">
              <h4 class="card-title">Table Report</h4>
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
                  <th>Prasyarat / Catatan Surat</th>
                  <th>Catatan</th>
                  <th>Status</th>
                  <th>Tanggal Update</th>
                </tr>
              </thead>
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

      $('#exportdate').html("<input type='text' name='sdate' value="+sdate+" style='display: none;'>");
      $('#exportdate').append("<input type='text' name='edate' value="+edate+" style='display: none;'>");
    });
  </script>
  <script>
    var table;
    $(function () {
      table = $('#datatables').DataTable({
            aaSorting: [[0, 'desc']],
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
              "url":"{{ url('report/fetchData') }}", 
              "type":"GET",
              "data": function (d){
                d.overall_filter = $('#overall_filter').val();
                d.sdate = sdate;
                d.edate = edate;
                d.filter_status = $('#filter_status').val();
              }
            },
            columns: [
                { data: 'created_at', name: 'created_at'},
                { data: 'name', name: 'name'},
                { data: 'nama_surat', name: 'nama_surat'},
                { data: 'prasyarat', name: 'prasyarat'},
                { data: 'catatan', name: 'catatan'},
                { data: 'status', name: 'status'},
                { data: 'updated_at', name: 'updated_at'},
            ]
        });
    });

    function reloadData(){
      table.ajax.reload();
    }
  </script>
  <script type="text/javascript">
    $('#dates').on('change', function() {
      table.ajax.reload();
    })
  </script>
@endsection