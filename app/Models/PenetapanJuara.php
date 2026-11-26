<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenetapanJuara extends Model
{
    protected $table = 'penetapan_juara';

    // Hanya ada created_at (sesuai ERD), tidak ada updated_at
    const UPDATED_AT = null;

    protected $fillable = [
        'turnamen_id',
        'pendaftaran_id',
        'user_id',
        'peringkat',
    ];

    public function turnamen(): BelongsTo
    {
        return $this->belongsTo(Turnamen::class, 'turnamen_id');
    }

    public function pendaftaran(): BelongsTo
    {
        return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
    }

    // Panitia yang menetapkan juara
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
