<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PenetapanJuaraController;
use App\Http\Controllers\TurnamenController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'role:panitia,peserta'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');

    // pendaftaran
    Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])
        ->name('pendaftaran.create');

    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');
});

// crud games khusus panitia
Route::middleware(['auth', 'role:panitia'])->group(function () {
    Route::resource('games', GameController::class)->except(['show']);
});

Route::middleware(['auth', 'role:panitia'])
    ->prefix('penetapan-juara')
    ->name('penetapan-juara.')
    ->group(function () {
        Route::get('/', [PenetapanJuaraController::class, 'index'])->name('index');
        Route::get('/{turnamen}', [PenetapanJuaraController::class, 'show'])->name('show');
        Route::post('/{turnamen}', [PenetapanJuaraController::class, 'store'])->name('store');
        Route::delete('/{turnamen}', [PenetapanJuaraController::class, 'destroy'])->name('destroy');
    });

Route::middleware(['auth', 'role:panitia'])->group(function () {
    Route::resource('turnamen', TurnamenController::class)
        ->except(['show'])
        // Paksa nama parameter agar route model binding tidak salah tebak
        ->parameters(['turnamen' => 'turnamen']);
});