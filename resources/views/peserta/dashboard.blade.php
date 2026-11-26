@extends('layouts.app')

@section('title', 'Dashboard Peserta - ARCHAMP')

@section('content')
    <h1>Dashboard Peserta</h1>
    <p>Selamat datang di ARCHAMP!</p>

    <div style="margin-top: 25px;">
        <h3>Menu Peserta</h3>

        <ul style="margin: 15px 0 0 20px; line-height: 2;">
            <li><a href="#">Lihat Turnamen</a></li>
            <li><a href="#">Pendaftaran Saya</a></li>
            <li><a href="#">Jadwal Pertandingan</a></li>
            <li><a href="#">Hasil Pertandingan</a></li>
            <li><a href="#">Daftar Juara</a></li>
        </ul>
    </div>
@endsection
