<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalPertandinganController extends Controller
{
    //
}

<?php

namespace App\Http\Controllers;

use App\Models\JadwalPertandingan;
use Illuminate\Http\Request;

class JadwalPertandinganController extends Controller
{
    // Menampilkan seluruh jadwal pertandingan
    public function index()
    {
        $jadwal = JadwalPertandingan::all();

        return response()->json([
            'message' => 'Data jadwal pertandingan berhasil ditampilkan',
            'data' => $jadwal
        ], 200);
    }

    // Menambahkan jadwal pertandingan
    public function store(Request $request)
    {
        $request->validate([
            'turnamen_id' => 'required|exists:turnamen,id',
            'peserta_1_id' => 'required|exists:pendaftaran,id',
            'peserta_2_id' => 'required|different:peserta_1_id|exists:pendaftaran,id',
            'next_match_id' => 'nullable|exists:jadwal_pertandingan,id',
            'next_match_slot' => 'nullable|string|max:20',
            'user_id' => 'required|exists:users,id',
            'tanggal_pertandingan' => 'required|date',
            'jam_pertandingan' => 'required',
            'mode_pelaksanaan' => 'required|string|max:20',
            'lokasi' => 'nullable|string',
            'link_pertandingan' => 'nullable|url',
            'status' => 'required|string|max:20',
        ]);

        $jadwal = JadwalPertandingan::create($request->all());

        return response()->json([
            'message' => 'Jadwal pertandingan berhasil ditambahkan',
            'data' => $jadwal
        ], 201);
    }
}
