
<h2>Form Pendaftaran Turnamen Archamp</h2>

@if ($errors->any())
    @foreach ($errors->all() as $e)
        <p>{{ $e }}</p>
    @endforeach
@endif

<form method="POST" action="/pendaftaran">
    @csrf

    <label>Pilih Turnamen</label>
    <select name="turnamen_id">
        <option value="">-- Pilih Turnamen --</option>

        @foreach ($turnamen as $t)
            <option value="{{ $t->id }}"
                {{ old('turnamen_id') == $t->id ? 'selected' : '' }}>
                {{ $t->nama_turnamen }}
            </option>
        @endforeach
    </select>

    @error('turnamen_id')
        <p>{{ $message }}</p>
    @enderror

    <br>

    <label>Nama Tim (kosongkan jika individu)</label>
    <input type="text" name="nama_tim"
        value="{{ old('nama_tim') }}">

    @error('nama_tim')
        <p>{{ $message }}</p>
    @enderror

    <br>

    <hr>
    <h3>Data Anggota</h3>

    <label>Nama Anggota</label>
    <input type="text" name="anggota[0][nama_anggota]"
        value="{{ old('anggota.0.nama_anggota') }}">

    @error('anggota.0.nama_anggota')
        <p>{{ $message }}</p>
    @enderror

    <br>

    <label>Nomor Identitas Anggota</label>
    <input type="text" name="anggota[0][identitas_anggota]"
        value="{{ old('anggota.0.identitas_anggota') }}">

    @error('anggota.0.identitas_anggota')
        <p>{{ $message }}</p>
    @enderror

    <br>

    <label>Posisi</label>
    <input type="text" name="anggota[0][posisi]"
        value="{{ old('anggota.0.posisi') }}">

    <br>
    <button type="submit">Daftar</button>
</form>
