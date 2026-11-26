
@extends('layouts.app')

@section('title', 'Kategori Kompetisi - Archamp')

@section('content')

<h1 style="color: #17365D; margin-bottom: 20px;">
    Kategori Kompetisi
</h1>

<a href="{{ route('kategori-kompetisi.create') }}"
   style="display: inline-block; background: #17365D; color: white; padding: 10px 18px; text-decoration: none; border-radius: 6px; margin-bottom: 20px;">
    + Tambah Kategori
</a>

@if (session('success'))
    <p style="color: green; margin-bottom: 15px;">
        {{ session('success') }}
    </p>
@endif

<div style="background: white; padding: 20px; border-radius: 10px; overflow-x: auto;">

    <table style="width: 100%; border-collapse: collapse;">

        <thead>
            <tr style="background: #f4f6f9;">
                <th>No</th>
                <th>Game</th>
                <th>Nama Kategori</th>
                <th>Tipe Peserta</th>
                <th>Minimal Anggota</th>
                <th>Maksimal Anggota</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($kategori as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->game->nama_game ?? '-' }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>{{ $item->tipe_peserta }}</td>
                    <td>{{ $item->minimal_anggota }}</td>
                    <td>{{ $item->maksimal_anggota }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">
                        Belum ada kategori kompetisi.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>

</div>

@endsection
