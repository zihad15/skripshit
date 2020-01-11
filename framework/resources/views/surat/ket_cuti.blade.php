@extends('layouts.app_base_surat')
@section('content')
    <table>
      <tr>
      	<td>Yang bertanda tangan dibawah ini Kabag Administrasi Akademik Universitas Trilogi menerangkan bahwa :</td>
      </tr>
  	</table>
  	<table>
      <tr>
        <td height="20"></td>
      </tr>
      <tr>
        <td width="150">Nama</td>
        <td>:</td>
        <td>{{ $user->name }}</td>
      </tr>
      <tr>
        <td>NIM</td>
        <td>:</td>
        <td>{{ $user->nim_nip }}</td>
      </tr>
      <tr>
        <td>Program Studi</td>
        <td>:</td>
        <td>{{ $prodi->nama_prodi }}</td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $user->alamat }}</td>
      </tr>
      <tr>
        <td height="20"></td>
      </tr>
    </table>
	<table>
		<tr>
	  		<td>Telah mengajukan permohonan Cuti untuk keperluan :</td>
	  	</tr>
	</table>
    <table>
      <tr>
      	<td height="20"></td>
      </tr>
      <tr>
      	<td width="150">Alasan Cuti</td>
      	<td>:</td>
      	<td>{{ $surat->catatan_surat }}</td>
      </tr>
      <tr>
        <td>Semester Cuti</td>
        <td>:</td>
        <td>Semester {{ Config::get('constants.SEMESTER') }} {{ Config::get('constants.TAHUN_AKADEMIK') }}</td>
      </tr>
      <tr>
      	<td>Catatan Daftar Ulang</td>
      	<td>:</td>
      	<td>Semester {{ Config::get('constants.SEMESTER_ANTONIM') }} Tahun Akademik :  {{ Config::get('constants.TAHUN_AKADEMIK_PLUS1') }}</td>
      </tr>
  	</table>
@endsection