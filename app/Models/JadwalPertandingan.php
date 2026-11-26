<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPertandingan extends Model
{
    protected $table = 'jadwal_pertandingan';

    public $timestamps = false;

    protected $fillable = [
        'turnamen_id',
        'peserta_1_id',
        'peserta_2_id',
        'next_match_id',
        'next_match_slot',
        'user_id',
        'tanggal_pertandingan',
        'jam_pertandingan',
        'mode_pelaksanaan',
        'lokasi',
        'link_pertandingan',
        'status',
    ];

    public function turnamen()
    {
        return $this->belongsTo(Turnamen::class);
    }

    public function peserta1()
    {
        return $this->belongsTo(Pendaftaran::class, 'peserta_1_id');
    }

    public function peserta2()
    {
        return $this->belongsTo(Pendaftaran::class, 'peserta_2_id');
    }

    public function nextMatch()
    {
        return $this->belongsTo(JadwalPertandingan::class, 'next_match_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasilPertandingan()
    {
        return $this->hasOne(HasilPertandingan::class);
    }
}
