<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriKompetisiController;
use App\Http\Controllers\JadwalPertandinganController;
use App\Http\Controllers\HasilPertandinganController;

Route::get('/', function () {
    return view('guest.home');
});

Route::resource('kategori-kompetisi', KategoriKompetisiController::class);

Route::resource('jadwal-pertandingan', JadwalPertandinganController::class);

Route::resource('hasil-pertandingan', HasilPertandinganController::class);
