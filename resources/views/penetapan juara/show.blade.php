@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('penetapan-juara.index') }}" class="btn btn-sm btn-secondary mb-3">&larr; Kembali</a>

    <h3 class="mb-0">{{ $turnamen->nama_turnamen }}</h3>
    <p class="text-muted">
        {{ $turnamen->kategoriKompetisi->game->nama_game ?? '-' }} — {{ $turnamen->kategoriKompetisi->nama_kategori ?? '-' }}
    </p>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif
    @unless ($siap)
        <div class="alert alert-warning">
            Juara belum dapat ditetapkan. Pastikan jadwal sudah dibuat dan semua pertandingan berstatus selesai.
        </div>
    @endunless

    <h5>Rekapitulasi Hasil</h5>
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr><th>#</th><th>Peserta</th><th>Main</th><th>Menang</th><th>Kalah</th></tr>
            </thead>
            <tbody>
                @forelse ($rekap as $r)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $r->nama_peserta }}</td>
                        <td>{{ $r->main }}</td>
                        <td>{{ $r->menang }}</td>
                        <td>{{ $r->kalah }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada peserta yang diterima.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h5>Tetapkan Juara</h5>
    <form action="{{ route('penetapan-juara.store', $turnamen) }}" method="POST" class="mb-3">
        @csrf
        @foreach ([1 => true, 2 => true, 3 => false] as $peringkat => $wajib)
            @php $field = "juara_$peringkat"; $sekarang = optional($juara->get($peringkat))->pendaftaran_id; @endphp
            <div class="mb-3">
                <label class="form-label">Juara {{ $peringkat }} {!! $wajib ? '' : '<small class="text-muted">(opsional)</small>' !!}</label>
                <select name="{{ $field }}" class="form-select @error($field) is-invalid @enderror" @disabled(! $siap)>
                    <option value="">-- Pilih peserta --</option>
                    @foreach ($rekap as $r)
                        <option value="{{ $r->id }}" @selected(old($field, $sekarang) == $r->id)>
                            {{ $r->nama_peserta }} ({{ $r->menang }} menang)
                        </option>
                    @endforeach
                </select>
                @error($field) <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary" @disabled(! $siap)>Simpan Juara</button>
    </form>

    @if ($juara->isNotEmpty())
        <form action="{{ route('penetapan-juara.destroy', $turnamen) }}" method="POST"
              onsubmit="return confirm('Batalkan penetapan juara turnamen ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger">Batalkan Penetapan</button>
        </form>
    @endif
</div>
@endsection
