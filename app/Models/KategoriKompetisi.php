
<?php

namespace App\Http\Controllers;

use App\Models\KategoriKompetisi;
use Illuminate\Http\Request;

class KategoriKompetisiController extends Controller
{

    public function index()
    {
        $kategori = KategoriKompetisi::with('game')->get();

        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    // Menambahkan kategori kompetisi
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'nama_kategori' => 'required|string|max:100',
            'tipe_peserta' => 'required|string|max:20',
            'minimal_anggota' => 'required|integer|min:1',
            'maksimal_anggota' => 'required|integer|gte:minimal_anggota',
            'status' => 'sometimes|string|max:20',
        ]);

        $kategori = KategoriKompetisi::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori kompetisi berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }
}
