@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Tambah Game</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('games.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Game</label>
                    <input type="text"
                           name="nama_game"
                           class="form-control"
                           value="{{ old('nama_game') }}"
                           placeholder="Masukkan nama game">

                    @error('nama_game')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Developer</label>
                    <input type="text"
                           name="developer"
                           class="form-control"
                           value="{{ old('developer') }}"
                           placeholder="Masukkan nama developer">

                    @error('developer')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Pilih Status</option>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>

                <a href="{{ route('games.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>
@endsection
