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
        <td>Sudah memenuhi kriteria lulus semua mata kuliah</td>
      </tr>
      <tr>
        <td>3.</td>
        <td>Mempunyai Indek Prestasi Kumulatif (IPK), kecuali Tugas Akhir lebih besar atau sama dengan 2.00 (untuk S-1 dan D-3) dan 2.75 (S-2)</td>
      </tr>
      <tr>
        <td>4.</td>
        <td>Mendapat persetujuan dari dosen pembimbing bahwa Skripsi/Tugas Akhir sudah dapat di presentasikan.</td>
      </tr>
  	</table>
@endsection