<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
