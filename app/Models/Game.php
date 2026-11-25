<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['nama_game', 'developer', 'status'];

    public function kategoriKompetisi(){
        return $this->hasMany(KategoriKompetisi::class);
    }
}
