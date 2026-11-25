
@extends('layouts.app')

@section('title', 'Beranda - Archamp')

@section('content')

<style>
    .hero {
        background: #17365D;
        color: white;
        padding: 60px 40px;
        border-radius: 12px;
        text-align: center;
    }

    .hero h1 {
        font-size: 36px;
        margin-bottom: 15px;
    }

    .hero p {
        font-size: 16px;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .btn {
        display: inline-block;
        background: #F4B942;
        color: #17365D;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
    }

    .info {
        margin-top: 35px;
        text-align: center;
    }
</style>

<div class="hero">
    <h1>Welcome to ARCHAMP</h1>

    <p>
        Platform manajemen turnamen e-sports
        untuk mengelola kompetisi, jadwal pertandingan,
        hingga hasil pertandingan.
    </p>

    <a href="#" class="btn">
        Lihat Turnamen
    </a>
</div>

<div class="info">
    <h2>Kelola Turnamen Lebih Mudah</h2>
    <p>
        Archamp membantu panitia menyelenggarakan
        kompetisi e-sports secara terstruktur.
    </p>
</div>

@endsection
