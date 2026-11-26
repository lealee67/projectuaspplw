<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPendaftaran extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'nama_anggota',
        'identitas_anggota',
        'posisi'
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }
}
