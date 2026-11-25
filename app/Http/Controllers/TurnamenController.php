<?php

namespace App\Http\Controllers;

use App\Models\KategoriKompetisi;
use App\Models\Turnamen;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TurnamenController extends Controller
{
    public function index(): View
    {
        $turnamen = Turnamen::with('kategoriKompetisi.game')
            ->withCount('pendaftaran')
            ->orderByDesc('id')
            ->paginate(10);

        return view('turnamen.index', compact('turnamen'));
    }

    public function create(): View
    {
        return view('turnamen.create', [
            'kategori' => KategoriKompetisi::with('game')->orderBy('nama_kategori')->get(),
            'statusList' => Turnamen::STATUS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        Turnamen::create($data);

        return redirect()->route('turnamen.index')
            ->with('success', 'Turnamen berhasil ditambahkan.');
    }

    public function edit(Turnamen $turnamen): View
    {
        return view('turnamen.edit', [
            'turnamen' => $turnamen,
            'kategori' => KategoriKompetisi::with('game')->orderBy('nama_kategori')->get(),
            'statusList' => Turnamen::STATUS,
        ]);
    }

    public function update(Request $request, Turnamen $turnamen): RedirectResponse
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        // Mengganti kategori setelah ada pendaftar bisa merusak validasi min/max anggota
        if ((int) $data['kategori_kompetisi_id'] !== $turnamen->kategori_kompetisi_id
            && $turnamen->pendaftaran()->exists()) {
            return back()->withInput()->withErrors([
                'kategori_kompetisi_id' => 'Kategori tidak dapat diubah karena turnamen ini sudah memiliki pendaftaran.',
            ]);
        }

        // Kuota tidak boleh lebih kecil dari jumlah pendaftar yang ada
        $jumlahPendaftar = $turnamen->pendaftaran()->count();
        if ($data['kuota_peserta'] < $jumlahPendaftar) {
            return back()->withInput()->withErrors([
                'kuota_peserta' => "Kuota tidak boleh kurang dari jumlah pendaftar saat ini ($jumlahPendaftar).",
            ]);
        }

        $turnamen->update($data);

        return redirect()->route('turnamen.index')
            ->with('success', 'Turnamen berhasil diperbarui.');
    }

    public function destroy(Turnamen $turnamen): RedirectResponse
    {
        // Proteksi hapus master (aturan bisnis no. 8)
        if ($turnamen->sudahDipakaiTransaksi()) {
            return redirect()->route('turnamen.index')->with(
                'error',
                "Turnamen \"{$turnamen->nama_turnamen}\" tidak dapat dihapus karena sudah digunakan pada data transaksi (pendaftaran, jadwal, hasil, atau juara)."
            );
        }

        try {
            $turnamen->delete();
        } catch (QueryException $e) {
            // Jaga-jaga jika constraint FK di database yang menolak
            return redirect()->route('turnamen.index')->with(
                'error',
                'Turnamen tidak dapat dihapus karena masih terhubung dengan data lain.'
            );
        }

        return redirect()->route('turnamen.index')
            ->with('success', 'Turnamen berhasil dihapus.');
    }

    /* ---------- Validasi ---------- */

    private function rules(): array
    {
        return [
            'kategori_kompetisi_id' => ['required', 'exists:kategori_kompetisi,id'],
            'nama_turnamen'         => ['required', 'string', 'max:255'],
            'tanggal_mulai'         => ['required', 'date'],
            'tanggal_selesai'       => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'kuota_peserta'         => ['required', 'integer', 'min:1'],
            'biaya_pendaftaran'     => ['required', 'numeric', 'min:0'],
            'status'                => ['required', Rule::in(Turnamen::STATUS)],
        ];
    }

    private function messages(): array
    {
        return [
            'required'                      => ':attribute wajib diisi.',
            'exists'                        => ':attribute yang dipilih tidak valid.',
            'integer'                       => ':attribute harus berupa bilangan bulat.',
            'numeric'                       => ':attribute harus berupa angka.',
            'date'                          => ':attribute harus berupa tanggal yang valid.',
            'max'                           => ':attribute maksimal :max karakter.',
            'kuota_peserta.min'             => 'Kuota peserta minimal 1.',
            'biaya_pendaftaran.min'         => 'Biaya pendaftaran tidak boleh negatif.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'status.in'                     => 'Status tidak valid.',
        ];
    }

    private function attributes(): array
    {
        return [
            'kategori_kompetisi_id' => 'Kategori kompetisi',
            'nama_turnamen'         => 'Nama turnamen',
            'tanggal_mulai'         => 'Tanggal mulai',
            'tanggal_selesai'       => 'Tanggal selesai',
            'kuota_peserta'         => 'Kuota peserta',
            'biaya_pendaftaran'     => 'Biaya pendaftaran',
            'status'                => 'Status',
        ];
    }
}
