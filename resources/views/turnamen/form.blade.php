@php
    $isEdit = isset($turnamen);
    $val = fn ($field, $default = '') => old($field, $isEdit ? ($turnamen->$field ?? $default) : $default);
@endphp

<div class="mb-3">
    <label class="form-label">Kategori Kompetisi</label>
    <select name="kategori_kompetisi_id" class="form-select @error('kategori_kompetisi_id') is-invalid @enderror">
        <option value="">-- Pilih kategori --</option>
        @foreach ($kategori as $k)
            <option value="{{ $k->id }}" @selected($val('kategori_kompetisi_id') == $k->id)>
                {{ $k->game->nama_game ?? '-' }} — {{ $k->nama_kategori }}
            </option>
        @endforeach
    </select>
    @error('kategori_kompetisi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Turnamen</label>
    <input type="text" name="nama_turnamen" value="{{ $val('nama_turnamen') }}"
           class="form-control @error('nama_turnamen') is-invalid @enderror">
    @error('nama_turnamen') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai"
               value="{{ old('tanggal_mulai', $isEdit ? $turnamen->tanggal_mulai->format('Y-m-d') : '') }}"
               class="form-control @error('tanggal_mulai') is-invalid @enderror">
        @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai"
               value="{{ old('tanggal_selesai', $isEdit ? $turnamen->tanggal_selesai->format('Y-m-d') : '') }}"
               class="form-control @error('tanggal_selesai') is-invalid @enderror">
        @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Kuota Peserta</label>
        <input type="number" min="1" name="kuota_peserta" value="{{ $val('kuota_peserta') }}"
               class="form-control @error('kuota_peserta') is-invalid @enderror">
        @error('kuota_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Biaya Pendaftaran (Rp)</label>
        <input type="number" min="0" step="0.01" name="biaya_pendaftaran" value="{{ $val('biaya_pendaftaran', 0) }}"
               class="form-control @error('biaya_pendaftaran') is-invalid @enderror">
        @error('biaya_pendaftaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select @error('status') is-invalid @enderror">
        @foreach ($statusList as $s)
            <option value="{{ $s }}" @selected($val('status', 'dibuka') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<a href="{{ route('turnamen.index') }}" class="btn btn-secondary">Batal</a>
<button type="submit" class="btn btn-primary">Simpan</button>
