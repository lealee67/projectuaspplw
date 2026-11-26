<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriKompetisiController;
use App\Http\Controllers\JadwalPertandinganController;
use App\Http\Controllers\HasilPertandinganController;

Route::get('/', function () {
    return view('guest.home');
});

Route::get('/dashboard/peserta', function () {
    return view('peserta.dashboard');
})->name('peserta.dashboard');

Route::get('/dashboard/panitia', function () {
    return view('panitia.dashboard');
})->name('panitia.dashboard');

Route::resource('kategori-kompetisi', KategoriKompetisiController::class);

Route::resource('jadwal-pertandingan', JadwalPertandinganController::class);

Route::resource('hasil-pertandingan', HasilPertandinganController::class);
