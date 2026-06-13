<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Antrian\AntrianManager;
use App\Livewire\Antrian\PapanAntrian;
use App\Livewire\Dashboard\StatsDashboard;
use App\Livewire\Dokter\DokterManager;
use App\Livewire\Kunjungan\KunjunganManager;
use App\Livewire\Pasien\PasienManager;
use App\Livewire\Poli\PoliManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('login');
})->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', StatsDashboard::class)->name('dashboard');
    Route::get('/poli', PoliManager::class)->name('poli.index');
    Route::get('/dokter', DokterManager::class)->name('dokter.index');
    Route::get('/pasien', PasienManager::class)->name('pasien.index');
    Route::get('/antrian', AntrianManager::class)->name('antrian.index');
    Route::get('/kunjungan', KunjunganManager::class)->name('kunjungan.index');
});

Route::get('/papan-antrian', PapanAntrian::class)->name('papan.antrian');
