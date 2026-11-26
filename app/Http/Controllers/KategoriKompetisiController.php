<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\KategoriKompetisi;
use Illuminate\Http\Request;

class KategoriKompetisiController extends Controller
{
    // daftar kategori kompetisi
    public function index()
    {
        $kategori = KategoriKompetisi::with('game')->get();

        return view('panitia.kategori-kompetisi.index', compact('kategori'));

    }

    // form tambah kategori
    public function create()
    {
        $games = Game::all();

        return view('panitia.kategori-kompetisi.create', compact('games'));
    }

    // simpan kategori kompetisi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'nama_kategori' => 'required|string|max:100',
            'tipe_peserta' => 'required|string|max:20',
            'minimal_anggota' => 'required|Integer|min:1',
            'maksimal_anggota' => 'required|integer|gte:minimal_anggota',
            'status' => 'required|string|max:20',
        ]);

        $kategori = KategoriKompetisi::create($validated);

               return redirect()
            ->route('kategori-kompetisi.index')
            ->with('success', 'Kategori kompetisi berhasil ditambahkan.');
    }
}
