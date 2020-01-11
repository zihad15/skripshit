@extends('layouts.app_base_surat')
@section('content')
    <table>
      <tr>
      	<td>Yang bertanda tangan dibawah ini:</td>
      </tr>
  	</table>
  	<table>
      <tr>
      	<td height="20"></td>
      </tr>
      <tr>
      	<td width="120">Nama</td>
      	<td>:</td>
      	<td>{{ Config::get('constants.NAMA_KEPALA_AKADEMIK') }}</td>
      </tr>
      <tr>
      	<td>NIDN</td>
      	<td>:</td>
      	<td>{{ Config::get('constants.NIDN_KEPALA_AKADEMIK') }}</td>
      </tr>
      <tr>
      	<td>Jabatan</td>
      	<td>:</td>
      	<td>{{ Config::get('constants.JABATAN_KEPALA_AKADEMIK') }}</td>
      </tr>
      <tr>
      	<td height="20"></td>
      </tr>
  	</table>
	<table>
		<tr>
	  		<td>Dengan ini menyatakan yang sesungguhnya bahwa.</td>
	  	</tr>
	</table>
    <table>
      <tr>
      	<td height="20"></td>
      </tr>
      <tr>
      	<td width="120">Nama</td>
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
      	<td height="20"></td>
      </tr>
  	</table>
    <table>
      <tr>
      	<td colspan="3">Adalah benar mahasiswa Universitas Trilogi yang masih aktif kuliah pada Semester {{ Config::get('constants.SEMESTER') }} Tahun Akademik {{ Config::get('constants.TAHUN_AKADEMIK') }}</td>
      </tr>
      <tr>
      	<td height="20"></td>
      </tr>
      <tr>
      	<td colspan="3">Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana semestinya.</td>
      </tr>
    </table>
@endsection