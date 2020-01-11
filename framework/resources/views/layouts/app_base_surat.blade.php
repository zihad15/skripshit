<!DOCTYPE html>
<html>
  <head>
    <style>
    body {
        height: 842px;
        width: 595px;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
    }
    </style>
  </head>
  <body>
    <table>
      <tr>
        <td class="text-left">
          <img src="{{ asset('assets/images/logo-trilogi.png') }}" width="380" height="100">
        </td>
      </tr>
      <tr>
        <td height="40"></td>
      </tr>
    </table>
    <center>
      <u>
        @if(isset($surat->nama_surat))
          {{ strtoupper($surat->nama_surat) }}
        @endif
      </u> 
      <br> 
      @if(isset($surat->nomor_surat))
        {{ strtoupper($surat->nomor_surat) }}
      @endif
    </center>
    <br>
    <br>
    @yield('content')
    <br>
    <br>
    <br>
    <br>
    <table style="width: 100%">
      <tr>
        <td style="text-align: right; padding-right: 6%;">
          Jakarta, 
          @if(isset($surat->tgl_acc_kabag))
            {{ $surat->tgl_acc_kabag }}
          @else
            <label style="color: red;">menunggu persetujuan kabag.</label>
          @endif
        </td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
    <table style="width: 100%;">
      <tr>
        <td style="text-align: right;">
          @if(!empty($surat->ttd_kabag_akademik))
            <img src="{{ asset('assets/images/'.$surat->ttd_kabag_akademik) }}">
          @else
            <img src="{{ asset('assets/images/none_ttd.jpg') }}" height="100">
          @endif
        </td>
      </tr>
    </table>
    <table style="width: 100%">
      <tr>
        <td></td>
      </tr>
      <tr>
        <td style="text-align: right;">
          <u>{{ Config::get('constants.NAMA_KEPALA_AKADEMIK') }}</u>
          <br>
          {{ Config::get('constants.JABATAN_KEPALA_AKADEMIK') }}
        </td>
      </tr>
    </table>
  </body>
</html>