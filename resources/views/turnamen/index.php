@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Turnamen</h3>
        <a href="{{ route('turnamen.create') }}" class="btn btn-primary">+ Tambah Turnamen</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Turnamen</th>
                    <th>Game / Kategori</th>
                    <th>Tanggal</th>
                    <th>Pendaftar / Kuota</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th style="width:150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($turnamen as $t)
                    <tr>
                        <td>{{ $turnamen->firstItem() + $loop->index }}</td>
                        <td>{{ $t->nama_turnamen }}</td>
                        <td>
                            {{ $t->kategoriKompetisi->game->nama_game ?? '-' }}<br>
                            <small class="text-muted">{{ $t->kategoriKompetisi->nama_kategori ?? '-' }}</small>
                        </td>
                        <td>{{ $t->tanggal_mulai->format('d/m/Y') }} – {{ $t->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>{{ $t->pendaftaran_count }} / {{ $t->kuota_peserta }}</td>
                        <td>Rp {{ number_format($t->biaya_pendaftaran, 0, ',', '.') }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($t->status) }}</span></td>
                        <td>
                            <a href="{{ route('turnamen.edit', $t) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('turnamen.destroy', $t) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus turnamen ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">Belum ada data turnamen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $turnamen->links() }}
</div>
@endsection
