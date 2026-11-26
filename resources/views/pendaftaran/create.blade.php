@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Pendaftaran Turnamen</h4>
                </div>

                <div class="card-body">

                    {{-- Pesan Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Periksa kembali data lu:</strong>

                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Form Pendaftaran --}}
                    <form method="POST" action="{{ route('pendaftaran.store') }}">
                        @csrf

                        {{-- Pilih Turnamen --}}
                        <div class="mb-3">
                            <label class="form-label">Pilih Turnamen</label>

                            <select name="turnamen_id" class="form-select" required>
                            <option value="">-- Pilih Turnamen --</option>

                            @foreach ($turnamen as $t)

                                @php
                                    $kategori = $kategoriKompetisi[$t->kategori_id] ?? null;
                                @endphp

                                <option value="{{ $t->id }}"
                                    {{ old('turnamen_id') == $t->id ? 'selected' : '' }}>

                                    {{ $t->nama_turnamen }}

                                    @if ($kategori)
                                        ({{ $kategori->nama_kategori }} -
                                        {{ $kategori->tipe_peserta }},
                                        {{ $kategori->minimal_anggota }}-{{ $kategori->maksimal_anggota }} anggota)
                                    @else
                                        (Kategori belum tersedia)
                                    @endif

                                </option>

                             @endforeach
                        </select>
                        </div>

                        {{-- Nama Tim --}}
                        <div class="mb-4">
                            <label class="form-label">Nama Tim</label>

                            <input type="text"
                                name="nama_tim"
                                class="form-control"
                                value="{{ old('nama_tim') }}"
                                placeholder="Kosongkan jika kategori individu">
                        </div>

                        <hr>

                        {{-- Data Anggota --}}
                        <h5 class="mb-3">Data Anggota</h5>

                        <div id="daftar-anggota">

                            @foreach (old('anggota', [['nama_anggota' => '', 'identitas_anggota' => '', 'posisi' => '']]) as $i => $anggota)

                                <div class="anggota-item border rounded p-3 mb-3">

                                    <h6 class="mb-3">Anggota {{ $i + 1 }}</h6>

                                    <div class="mb-3">
                                        <label class="form-label">Nama Anggota</label>

                                        <input type="text"
                                            name="anggota[{{ $i }}][nama_anggota]"
                                            class="form-control"
                                            value="{{ $anggota['nama_anggota'] ?? '' }}"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Nomor Identitas</label>

                                        <input type="text"
                                            name="anggota[{{ $i }}][identitas_anggota]"
                                            class="form-control"
                                            value="{{ $anggota['identitas_anggota'] ?? '' }}"
                                            required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Posisi</label>

                                        <input type="text"
                                            name="anggota[{{ $i }}][posisi]"
                                            class="form-control"
                                            value="{{ $anggota['posisi'] ?? '' }}">
                                    </div>

                                    <button type="button"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="hapusAnggota(this)">

                                        Hapus Anggota

                                    </button>

                                </div>

                            @endforeach

                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">

                            <button type="button"
                                class="btn btn-outline-primary"
                                onclick="tambahAnggota()">

                                + Tambah Anggota

                            </button>

                            <button type="submit" class="btn btn-primary">
                                Daftar Turnamen
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script>

    let nomorAnggota = {{ count(old('anggota', [['nama_anggota' => '', 'identitas_anggota' => '', 'posisi' => '']])) }};

    // Menambah anggota
    function tambahAnggota() {

        let daftar = document.getElementById('daftar-anggota');

        let anggotaBaru = document.createElement('div');

        anggotaBaru.className = 'anggota-item border rounded p-3 mb-3';

        anggotaBaru.innerHTML = `
            <h6 class="mb-3">Anggota ${nomorAnggota + 1}</h6>

            <div class="mb-3">
                <label class="form-label">Nama Anggota</label>
                <input type="text"
                    name="anggota[${nomorAnggota}][nama_anggota]"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Identitas</label>
                <input type="text"
                    name="anggota[${nomorAnggota}][identitas_anggota]"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Posisi</label>
                <input type="text"
                    name="anggota[${nomorAnggota}][posisi]"
                    class="form-control">
            </div>

            <button type="button"
                class="btn btn-outline-danger btn-sm"
                onclick="hapusAnggota(this)">

                Hapus Anggota

            </button>
        `;

        daftar.appendChild(anggotaBaru);

        nomorAnggota++;
    }

    // Menghapus anggota
    function hapusAnggota(tombol) {

        let daftar = document.getElementById('daftar-anggota');

        if (daftar.children.length > 1) {

            tombol.closest('.anggota-item').remove();

        } else {

            alert('Minimal harus ada satu anggota!');

        }
    }

</script>
@endsection
