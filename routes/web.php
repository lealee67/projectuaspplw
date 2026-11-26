
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\KategoriKompetisiController;
use App\Http\Controllers\JadwalPertandinganController;
use App\Http\Controllers\HasilPertandinganController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenetapanJuaraController;
use App\Http\Controllers\TurnamenController;

// halaman utama
Route::get('/', function () {
    return view('guest.home');
});

// login dan regis
Auth::routes();

// dashboard peserta
Route::middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/dashboard/peserta', function () {
        return view('peserta.dashboard');
    })->name('peserta.dashboard');
});

// dashboard dan pengelolaan panitia
Route::middleware(['auth', 'role:panitia'])->group(function () {

    Route::get('/dashboard/panitia', function () {
        return view('panitia.dashboard');
    })->name('panitia.dashboard');

    // crud games
    Route::resource('games', GameController::class)->except(['show']);

    // crud kategori kompetisi
    Route::resource('kategori-kompetisi', KategoriKompetisiController::class);

    // crud jadwal pertandingan
    Route::resource('jadwal-pertandingan', JadwalPertandinganController::class);

    // crud hasil pertandingan
    Route::resource('hasil-pertandingan', HasilPertandinganController::class);

    // crud turnamen
    Route::resource('turnamen', TurnamenController::class)->except(['show']);

    // penetapan juara
    Route::prefix('penetapan-juara')
        ->name('penetapan-juara.')
        ->group(function () {
            Route::get('/', [PenetapanJuaraController::class, 'index'])->name('index');
            Route::get('/{turnamen}', [PenetapanJuaraController::class, 'show'])->name('show');
            Route::post('/{turnamen}', [PenetapanJuaraController::class, 'store'])->name('store');
            Route::delete('/{turnamen}', [PenetapanJuaraController::class, 'destroy'])->name('destroy');
        });
});

// pendaftaran untuk peserta dan panitia
Route::middleware(['auth', 'role:panitia,peserta'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])
        ->name('home');

    Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])
        ->name('pendaftaran.create');

    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');
});
