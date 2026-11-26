
@extends('layouts.app')

@section('title', 'Dashboard Panitia - ARCHAMP')

@section('content')
    <h1>Dashboard Panitia</h1>
    <p>Selamat datang di halaman pengelolaan ARCHAMP!</p>

    <div style="margin-top: 25px;">
        <h3>Menu Pengelolaan</h3>

        <ul style="margin: 15px 0 0 20px; line-height: 2;">
            <li><a href="#">Kelola Game</a></li>
            <li><a href="{{ route('kategori-kompetisi.index') }}">Kelola Kategori Kompetisi</a></li>
            <li><a href="#">Kelola Turnamen</a></li>
            <li><a href="#">Verifikasi Pendaftaran</a></li>
            <li><a href="#">Kelola Jadwal Pertandingan</a></li>
            <li><a href="#">Kelola Hasil Pertandingan</a></li>
            <li><a href="#">Penetapan Juara</a></li>
        </ul>
    </div>
@endsection
