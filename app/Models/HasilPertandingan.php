<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPertandingan extends Model
{
    protected $table = 'hasil_pertandingan';

    protected $fillable = [
        'jadwal_pertandingan_id',
        'turnamen_id',
        'skor_peserta_1',
        'skor_peserta_2',
        'pemenang_pendaftaran_id',
        'user_id',
    ];
}
