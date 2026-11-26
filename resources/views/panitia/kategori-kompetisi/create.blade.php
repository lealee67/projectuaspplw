
@extends('layouts.app')

@section('title', 'Tambah Kategori Kompetisi - Archamp')

@section('content')

<h1 style="color: #17365D; margin-bottom: 20px;">
    Tambah Kategori Kompetisi
</h1>

<div style="background: white; padding: 25px; border-radius: 10px; max-width: 600px;">

    <form action="{{ route('kategori-kompetisi.store') }}" method="POST">
        @csrf

<label>Game</label>
<select name="game_id" required>
    <option value="">-- Pilih Game --</option>

    @foreach ($games as $game)
        <option value="{{ $game->id }}">
            {{ $game->nama_game }}
        </option>
    @endforeach
</select>

        <br><br>

        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" maxlength="100" required>

        <br><br>

        <label>Tipe Peserta</label>
        <select name="tipe_peserta" required>
            <option value="">-- Pilih Tipe Peserta --</option>
            <option value="Individu">Individu</option>
            <option value="Tim">Tim</option>
        </select>

        <br><br>

        <label>Minimal Anggota</label>
        <input type="number" name="minimal_anggota" min="1" required>

        <br><br>

        <label>Maksimal Anggota</label>
        <input type="number" name="maksimal_anggota" min="1" required>

        <br><br>

        <label>Status</label>
        <select name="status" required>
            <option value="Aktif">Aktif</option>
            <option value="Nonaktif">Nonaktif</option>
        </select>

        <br><br>

        <button type="submit">
            Simpan Kategori
        </button>

        <a href="{{ route('kategori-kompetisi.index') }}">
            Kembali
        </a>
    </form>

</div>

@endsection
