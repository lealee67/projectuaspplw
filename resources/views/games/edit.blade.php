
@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Edit Game</h3>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('games.update', $game->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Game</label>
                    <input type="text"
                           name="nama_game"
                           class="form-control"
                           value="{{ old('nama_game', $game->nama_game) }}">

                    @error('nama_game')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Developer</label>
                    <input type="text"
                           name="developer"
                           class="form-control"
                           value="{{ old('developer', $game->developer) }}">

                    @error('developer')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="aktif" {{ old('status', $game->status) == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="nonaktif" {{ old('status', $game->status) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>

                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('games.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>
@endsection
