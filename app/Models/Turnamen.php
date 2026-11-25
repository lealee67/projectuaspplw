<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turnamen extends Model
{
    // Laravel akan menebak "turnamens", jadi nama tabel wajib ditulis eksplisit
    protected $table = 'turnamen';

    // Tabel turnamen tidak punya created_at / updated_at (sesuai ERD)
    public $timestamps = false;

    protected $fillable = [
        'kategori_kompetisi_id',
        'nama_turnamen',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota_peserta',
        'biaya_pendaftaran',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai'     => 'date',
        'tanggal_selesai'   => 'date',
        'kuota_peserta'     => 'integer',
        'biaya_pendaftaran' => 'decimal:2',
    ];

    public const STATUS = ['dibuka', 'berlangsung', 'selesai', 'ditutup'];

    /* ---------- Relasi ---------- */

    // Turnamen milik satu kategori (game bisa diakses: $turnamen->kategoriKompetisi->game)
    public function kategoriKompetisi(): BelongsTo
    {
        return $this->belongsTo(KategoriKompetisi::class, 'kategori_kompetisi_id');
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'turnamen_id');
    }

    public function verifikasiPendaftaran(): HasMany
    {
        return $this->hasMany(VerifikasiPendaftaran::class, 'turnamen_id');
    }

    public function jadwalPertandingan(): HasMany
    {
        return $this->hasMany(JadwalPertandingan::class, 'turnamen_id');
    }

    public function hasilPertandingan(): HasMany
    {
        return $this->hasMany(HasilPertandingan::class, 'turnamen_id');
    }

    public function penetapanJuara(): HasMany
    {
        return $this->hasMany(PenetapanJuara::class, 'turnamen_id');
    }

    /* ---------- Helper ---------- */

    // Dipakai untuk proteksi hapus master (aturan bisnis no. 8)
    public function sudahDipakaiTransaksi(): bool
    {
        return $this->pendaftaran()->exists()
            || $this->verifikasiPendaftaran()->exists()
            || $this->jadwalPertandingan()->exists()
            || $this->hasilPertandingan()->exists()
            || $this->penetapanJuara()->exists();
    }
}
