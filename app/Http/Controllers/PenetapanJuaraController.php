<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PenetapanJuara;
use App\Models\Turnamen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PenetapanJuaraController extends Controller
{
    // Sesuaikan dengan nilai status buatan Anggota 1 (T2) dan Anggota 2 (T3/T4)
    private const STATUS_DITERIMA = 'diterima';
    private const STATUS_JADWAL_SELESAI = 'selesai';

    /** Daftar turnamen beserta kesiapan penetapan juara */
    public function index(): View
    {
        $turnamen = Turnamen::with('kategoriKompetisi.game')
            ->withCount([
                'jadwalPertandingan',
                'jadwalPertandingan as jadwal_selesai_count' => fn ($q) => $q->where('status', self::STATUS_JADWAL_SELESAI),
                'penetapanJuara',
            ])
            ->orderByDesc('id')
            ->paginate(10);

        return view('penetapan_juara.index', compact('turnamen'));
    }

    /** Rekap hasil + form penetapan juara untuk satu turnamen */
    public function show(Turnamen $turnamen): View
    {
        $turnamen->load('kategoriKompetisi.game');

        return view('penetapan_juara.show', [
            'turnamen' => $turnamen,
            'rekap'    => $this->rekap($turnamen),
            'siap'     => $this->siapDitetapkan($turnamen),
            'juara'    => PenetapanJuara::where('turnamen_id', $turnamen->id)
                            ->orderBy('peringkat')->get()->keyBy('peringkat'),
        ]);
    }

    /** Simpan juara 1-3 secara atomik (hapus lama, simpan baru) */
    public function store(Request $request, Turnamen $turnamen): RedirectResponse
    {
        if (! $this->siapDitetapkan($turnamen)) {
            return back()->with('error', 'Juara belum dapat ditetapkan: semua pertandingan harus sudah selesai.');
        }

        // Hanya pendaftaran yang diterima pada turnamen ini yang boleh dipilih
        $eligible = $this->rekap($turnamen)->pluck('id')->all();

        $data = $request->validate([
            'juara_1' => ['required', Rule::in($eligible)],
            'juara_2' => ['required', Rule::in($eligible), 'different:juara_1'],
            'juara_3' => ['nullable', Rule::in($eligible), 'different:juara_1', 'different:juara_2'],
        ], [
            'required'  => ':attribute wajib dipilih.',
            'in'        => ':attribute harus peserta yang diterima pada turnamen ini.',
            'different' => 'Satu peserta tidak boleh memiliki lebih dari satu peringkat.',
        ], [
            'juara_1' => 'Juara 1',
            'juara_2' => 'Juara 2',
            'juara_3' => 'Juara 3',
        ]);

        DB::transaction(function () use ($turnamen, $data) {
            PenetapanJuara::where('turnamen_id', $turnamen->id)->delete();

            foreach ([1 => $data['juara_1'], 2 => $data['juara_2'], 3 => $data['juara_3'] ?? null] as $peringkat => $pendaftaranId) {
                if ($pendaftaranId) {
                    PenetapanJuara::create([
                        'turnamen_id'    => $turnamen->id,
                        'pendaftaran_id' => $pendaftaranId,
                        'user_id'        => Auth::id(),
                        'peringkat'      => $peringkat,
                    ]);
                }
            }

            // Transaksi mengubah data lain: turnamen dinyatakan selesai
            $turnamen->update(['status' => 'selesai']);
        });

        return redirect()->route('penetapan-juara.show', $turnamen)
            ->with('success', 'Juara turnamen berhasil ditetapkan.');
    }

    /** Batalkan penetapan juara (kembalikan turnamen ke berlangsung) */
    public function destroy(Turnamen $turnamen): RedirectResponse
    {
        DB::transaction(function () use ($turnamen) {
            PenetapanJuara::where('turnamen_id', $turnamen->id)->delete();
            $turnamen->update(['status' => 'berlangsung']);
        });

        return redirect()->route('penetapan-juara.show', $turnamen)
            ->with('success', 'Penetapan juara dibatalkan.');
    }

    /* ---------- Helper ---------- */

    /** Siap jika ada jadwal dan semuanya sudah selesai */
    private function siapDitetapkan(Turnamen $turnamen): bool
    {
        $total = $turnamen->jadwalPertandingan()->count();

        return $total > 0
            && ! $turnamen->jadwalPertandingan()->where('status', '!=', self::STATUS_JADWAL_SELESAI)->exists();
    }

    /** Rekap peserta diterima: jumlah main, menang, kalah (Query Builder) */
    private function rekap(Turnamen $turnamen): Collection
    {
        return DB::table('pendaftaran as p')
            ->where('p.turnamen_id', $turnamen->id)
            ->where('p.status', self::STATUS_DITERIMA)
            ->selectRaw("
                p.id,
                COALESCE(p.nama_tim, (
                    SELECT d.nama_anggota FROM detail_pendaftaran d
                    WHERE d.pendaftaran_id = p.id ORDER BY d.id LIMIT 1
                )) AS nama_peserta,
                (SELECT COUNT(*) FROM jadwal_pertandingan j
                    WHERE j.turnamen_id = p.turnamen_id
                      AND j.status = ?
                      AND (j.peserta_1_id = p.id OR j.peserta_2_id = p.id)) AS main,
                (SELECT COUNT(*) FROM hasil_pertandingan h
                    WHERE h.turnamen_id = p.turnamen_id
                      AND h.pemenang_pendaftaran_id = p.id) AS menang
            ", [self::STATUS_JADWAL_SELESAI])
            ->orderByDesc('menang')
            ->orderBy('nama_peserta')
            ->get()
            ->map(function ($row) {
                $row->kalah = $row->main - $row->menang;
                return $row;
            });
    }
}
