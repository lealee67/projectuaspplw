<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pendaftaran extends Model
{
     protected $fillable = [
        'turnamen_id',
        'user_id',
        'nama_tim',
        'status'
    ];

    public function turnamen()
    {
        return $this->belongsTo(Turnamen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPendaftaran()
    {
        return $this->hasMany(DetailPendaftaran::class);
    }
}
