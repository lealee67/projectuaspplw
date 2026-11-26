@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-3">Penetapan Juara</h3>

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
                    <th>Pertandingan Selesai</th>
                    <th>Juara</th>
                    <th style="width:140px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($turnamen as $t)
                    @php $siap = $t->jadwal_pertandingan_count > 0 && $t->jadwal_pertandingan_count === $t->jadwal_selesai_count; @endphp
                    <tr>
                        <td>{{ $turnamen->firstItem() + $loop->index }}</td>
                        <td>{{ $t->nama_turnamen }}</td>
                        <td>
                            {{ $t->kategoriKompetisi->game->nama_game ?? '-' }}<br>
                            <small class="text-muted">{{ $t->kategoriKompetisi->nama_kategori ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $t->jadwal_selesai_count }} / {{ $t->jadwal_pertandingan_count }}
                            @if ($siap) <span class="badge bg-success">Siap</span> @endif
                        </td>
                        <td>
                            @if ($t->penetapan_juara_count > 0)
                                <span class="badge bg-primary">Sudah ditetapkan</span>
                            @else
                                <span class="badge bg-secondary">Belum</span>
                            @endif
                        </td>
                        <td><a href="{{ route('penetapan-juara.show', $t) }}" class="btn btn-sm btn-primary">Kelola</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada turnamen.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $turnamen->links() }}
</div>
@endsection
