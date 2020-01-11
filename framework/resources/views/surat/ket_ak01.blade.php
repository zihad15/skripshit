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
        <td>Jenjang Pendidikan</td>
        <td>:</td>
        <td>{{ ucwords($user->jenjang_pendidikan) }}</td>
      </tr>
      <tr>
        <td height="20"></td>
      </tr>
    </table>
	<table>
		<tr>
	  		<td>Telah memenuhi persyaratan menyusun skripsi / Tugas Akhir, yaitu :</td>
	  	</tr>
	</table>
    <table>
      <tr>
      	<td height="10"></td>
      </tr>
      <tr>
      	<td width="15">1.</td>
      	<td>Terdaftar dan tidak cuti akademik</td>
      </tr>
      <tr>
        <td>2.</td>
        <td>Mempunyai Indeks Prestasi Kumulatif (IPK) lebih besar atau sama dengan 2.00</td>
      </tr>
      <tr>
        <td>3.</td>
        <td>Sudah memiliki tabungan SKS lebih besar atau sama dengan 120 SKS</td>
      </tr>
      <tr>
        <td>4.</td>
        <td>Lulus matakuliah Metode Penelitian dan Statistika</td>
      </tr>
  	</table>
@endsection