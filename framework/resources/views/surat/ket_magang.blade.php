@extends('layouts.app_base_surat')
@section('content')
    <table style="width: 100%; padding-left: 70%">
      <tr>
      	<td>Kepada Yth,</td>
      </tr>
      <tr>
        <td style="white-space: pre-line">{!! $surat->catatan_surat !!}</td>
      </tr>
  	</table>
  	<table>
      <tr>
      	<td height="20"></td>
      </tr>
      <tr>
      	<td>Dengan hormat,</td>
      </tr>
      <tr>
        <td height="20"></td>
      </tr>
      <tr>
      	<td style="white-space: nowrap;">Dalam rangka pengenalan dunia kerja yang akan dilakukan oleh mahasiswa kami dibawah ini :</td>
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
      	<td colspan="3">Kami mohon diperkenankan Bapak/Ibu untuk dapat memberi kesempatan kepada peserta didik kami yang akan melaksanakan Praktek Kerja Lapangan (MAGANG).</td>
      </tr>
      <tr>
      	<td height="20"></td>
      </tr>
      <tr>
      	<td colspan="3">Demikian atas perhatian dan kerjasama Bapak/Ibu, kami ucapkan terima kasih.</td>
      </tr>
    </table>
@endsection