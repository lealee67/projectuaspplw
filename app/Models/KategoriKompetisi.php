<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KategoriKompetisi extends Model
{
    protected $table = 'kategori_kompetisi';

    protected $fillable = [
        'game_id',
        'nama_kategori',
        'tipe_peserta',
        'minimal_anggota',
        'maksimal_anggota',
        'status',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
