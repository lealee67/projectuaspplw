<?php

namespace App\Http\Controllers;

use App\Models\HasilPertandingan;
use Illuminate\Http\Request;

class HasilPertandinganController extends Controller
{
    // Menampilkan seluruh hasil pertandingan
    public function index()
    {
        $hasil = HasilPertandingan::all();

        return response()->json([
            'message' => 'Data hasil pertandingan berhasil ditampilkan',
            'data' => $hasil
        ], 200);
    }

    // Menambahkan hasil pertandingan
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pertandingan_id' => 'required|exists:jadwal_pertandingan,id|unique:hasil_pertandingan,jadwal_pertandingan_id',
            'turnamen_id' => 'required|exists:turnamen,id',
            'skor_peserta_1' => 'required|unsignedInteger|min:0',
            'skor_peserta_2' => 'required|unsignedInteger|min:0',
            'pemenang_pendaftaran_id' => 'required|exists:pendaftaran,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $hasil = HasilPertandingan::create($request->all());

        return response()->json([
            'message' => 'Hasil pertandingan berhasil ditambahkan',
            'data' => $hasil
        ], 201);
    }
}
