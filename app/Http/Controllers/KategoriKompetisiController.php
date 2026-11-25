
<?php

namespace App\Http\Controllers;

use App\Models\KategoriKompetisi;
use Illuminate\Http\Request;

class KategoriKompetisiController extends Controller
{
    public function index()
    {
        $kategori = KategoriKompetisi::all();

        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriKompetisi::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategori kompetisi berhasil ditambahkan',
            'data' => $kategori
        ], 201);
    }
}
