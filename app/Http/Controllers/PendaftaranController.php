<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\DetailPendaftaran;
use App\Models\KategoriKompetisi;
use App\Models\Turnamen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PendaftaranController extends Controller
{
    public function create(){
        $turnamen = Turnamen::where('status', 'dibuka')->get();
        $kategoriKompetisi = KategoriKompetisi::all()->keyBy('id');

        return view('pendaftaran.create', compact('turnamen'));
    }

    public function store(Request $request){
    $validated = $request->validate([
        'turnamen_id' => 'required|exists:turnamen,id',
        'nama_tim' => 'nullable|string|max:100',
        'anggota' => 'required|array|min:1',
        'anggota.*.nama_anggota' => 'required|string|max:100',
        'anggota.*.identitas_anggota' => 'required|string|max:100',
        'anggota.*.posisi' => 'nullable|string|max:50',
    ]);

    // cari turnamen
    $pilihanTurnamen = Turnamen::findOrFail($validated['turnamen_id']);

    // cek status turnamen
        if ($pilihanTurnamen->status != 'dibuka') {
            return back()->withErrors([
                'turnamen_id' => 'Turnamen sudah tidak dibuka.'
            ])->withInput();
        }

    // cari kategori kompetisi
    $kategori = KategoriKompetisi::findOrFail(
        $pilihanTurnamen->kategori_id
    );

    // cek jumlah anggota
    $jumlahAnggota = count($validated['anggota']);

        if ($jumlahAnggota < $kategori->minimal_anggota || $jumlahAnggota > $kategori->maksimal_anggota) {
            return back()->withErrors([
                'anggota' => 'Jumlah anggota tidak sesuai dengan ketentuan kategori.'
            ])->withInput();
        }

    // simpan data pendaftaran
    $pendaftaran = Pendaftaran::create([
        'turnamen_id' => $pilihanTurnamen->id,
        'user_id' => Auth::id(),
        'nama_tim' => $validated['nama_tim'],
        'status' => 'menunggu',
    ]);

    // simpan data anggota
    foreach ($validated['anggota'] as $anggota) {
        DetailPendaftaran::create([
            'pendaftaran_id' => $pendaftaran->id,
            'nama_anggota' => $anggota['nama_anggota'],
            'identitas_anggota' => $anggota['identitas_anggota'],
            'posisi' => $anggota['posisi'] ?? null,
        ]);
    }

    return redirect()->route('pendaftaran.create')
        ->with('success', 'Pendaftaran berhasil dikirim!');
    }
}

