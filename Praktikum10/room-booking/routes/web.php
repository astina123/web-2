<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\{
    Counter,
    Ruang\ListRuang,
    Ruang\CreateRuang,
    Ruang\EditRuang,
    Pegawai\ListPegawai,
    Pegawai\CreatePegawai,
    Pegawai\EditPegawai,
    UnitKerja\ListUnitKerja,
    UnitKerja\CreateUnitKerja,
    UnitKerja\EditUnitKerja,
    Peminjaman\ListPeminjaman,
    Peminjaman\CreatePeminjaman,
    Peminjaman\EditPeminjaman,
    Settings\Appearance,
    Settings\Password,
    Settings\Profile
};

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/counter', Counter::class)->name('counter');

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Ruang Management
    Route::prefix('ruang')->group(function () {
        Route::get('/', ListRuang::class)->name('ruang.index');
        Route::get('/create', CreateRuang::class)->name('ruang.create');
        Route::get('/edit/{ruang}', EditRuang::class)->name('ruang.edit');
    });

    // Unit Kerja Management
    Route::prefix('unit-kerja')->group(function () {
        Route::get('/', ListUnitKerja::class)->name('unit-kerja.index');
        Route::get('/create', CreateUnitKerja::class)->name('unit-kerja.create');
        Route::get('/edit/{unitKerja}', EditUnitKerja::class)->name('unit-kerja.edit');
    });

    // Pegawai Management
    Route::prefix('pegawai')->group(function () {
        Route::get('/', ListPegawai::class)->name('pegawai.index');
        Route::get('/create', CreatePegawai::class)->name('pegawai.create');
        Route::get('/edit/{pegawai}', EditPegawai::class)->name('pegawai.edit');
    });

    // Peminjaman Management
    Route::prefix('peminjaman')->group(function () {
        Route::get('/create', CreatePeminjaman::class)->name('peminjaman.create');
        Route::get('/edit/{peminjaman}', EditPeminjaman::class)->name('peminjaman.edit');
    });

    // Settings Group
    Route::prefix('settings')->group(function () {
        Route::redirect('/', 'profile');
        Route::get('profile', Profile::class)->name('settings.profile');
        Route::get('password', Password::class)->name('settings.password');
        Route::get('appearance', Appearance::class)->name('settings.appearance');
    });
});

require __DIR__ . '/auth.php';
