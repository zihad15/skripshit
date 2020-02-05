@extends('layouts.app_base')
@section('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- jQuery Modal -->
  <script type="text/javascript" src="{!! asset('assets/custom/modal.min.js') !!}"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <center>
                        Selamat Datang di Sistem Pengajuan Administrasi Akademik Universitas Trilogi
                    </center>
                </div>
                @if(Auth::user()->role_id != 4)
                    <div>
                        <input type="text" name="dates" id="dates" style="float: right; margin-right: 17%; width: 24%; text-align: center; margin-top: 3%;">
                    </div>
                @endif
                <div class="card-body">
                    @if(Auth::user()->role_id != 4)
                    <div id="loading_chart1" style="margin-bottom: -49%"> 
                        <center>                                           
                          <div class="spinner-border text-primary" style=" width: 7rem; height: 7rem; border-width: 1em;">
                          </div>
                          <p>loading chart...</p>
                        </center>
                    </div>
                        <div class="col-md-12" id="linechartdiv" style="width: 100%; height: 500px;"></div>
                    @else
                        <center>
                            You are logged in!
                        </center>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL PERHATIAN -->
<div class="modal" id="modal_notif_flexsm">
  <label>PERHATIAN!</label>
  @if(Auth::user()->flex_sm == 1)
    <p style="color: red;">Status Kemahasiswaan Anda adalah Tidak Aktif, Pengajuan pengaktifan Status Mahasiswa sedang dalam proses.</p>
  @else
    <p style="color: red;">Status Kemahasiswaan Anda adalah Tidak Aktif silahkan <a href="{{ url('users/requestFlexsm') }}" onclick="return confirm('Anda yakin ingin mengajukan pengaktifan Status Mahasiswa?');">klik dsini</a> untuk mengajukan pengaktifan Status Mahasiswa.</p>
  @endif
</div>
<!-- END MODAL PERHATIAN -->
<a href="#modal_notif_flexsm" rel="modal:open" id="flexsmCheckButton" style="display: none;"></a>
@endsection
@section('js')
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script type="text/javascript">
      var baseUrl = "{{ url('/') }}";
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

    var d7 = new Date(Date.now()-7*24*60*60*1000);
    var yesterday = d7.getDate()+"/"+months[d7.getMonth()]+"/"+d7.getFullYear();

    var sdate = d7.getFullYear()+"-"+monthsnumber[d7.getMonth()]+"-"+d7.getDate();
    var edate = d.getFullYear()+"-"+monthsnumber[d.getMonth()]+"-"+d.getDate();

    var arrDate = [];
    $('input[name="dates"]').daterangepicker({
      opens: 'left',
      startDate: yesterday,
      endDate: today,
      maxSpan: {
        days: 7
      },
      locale: {
        format: 'D/MMMM/YYYY'
      }, 
    }, function(start, end, label) {
      sdate = start.format('YYYY-MM-DD');
      edate = end.format('YYYY-MM-DD');
      
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawLineChart);
    });
  </script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawLineChart);
    function drawLineChart() {
      $.ajax({
        type: "GET",
        url: baseUrl+"/getDataPermohonan/",
        data: {
          sdate: sdate,
          edate: edate,
        },
        beforeSend: function(){
          $('#loading_chart1').show();
          $('#linechartdiv').html('');
        },
        complete: function(){
          $('#loading_chart1').hide();
        },
        success: function(response){
          var arrData = [
            ['TODAY - 7 DAYS AGO',
            'PERMOHONAN DIAJUKAN',
            'DITOLAK PETUGAS AKADEMIK',
            'DISETUJUI PETUGAS AKADEMIK',
            'DISETUJUI KEPALA AKADEMIK']
          ];            

          $.each (response, function (i, v) {
            var arrJson = [
              v.date,
              v.data[0].permohonan_diajukan,
              v.data[0].ditolak_petugas,
              v.data[0].disetujui_petugas,
              v.data[0].disetujui_kepala,
            ];
            
            arrData.push(arrJson);
          })

          var data = google.visualization.arrayToDataTable(arrData);

          var options = {
            title: 'Users Tagging Chart',
            curveType: 'function',
            legend: { position: 'bottom' }
          };

          var chart = new google.visualization.LineChart(document.getElementById('linechartdiv'));

          chart.draw(data, options);
        }
      });
    }
  </script>

  <script type="text/javascript">
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
