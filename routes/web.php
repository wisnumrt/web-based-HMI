<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Beranda;
use App\Livewire\Pekerjaan;
use App\Livewire\User;
use App\Livewire\Laporan;
use App\Livewire\Mesin;
use App\Livewire\PekerjaanOperator;
use App\Livewire\Produksi;

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', Beranda::class)->middleware(['auth'])->name('dashboard');
Route::get('/pekerjaan', Pekerjaan::class)->middleware(['auth'])->name('pekerjaan');
Route::get('/user', User::class)->middleware(['auth'])->name('karyawan');
Route::get('/laporan', Laporan::class)->middleware(['auth'])->name('laporan');
Route::get('/mesin', Mesin::class)->middleware(['auth'])->name('mesin');
Route::get('/kerja', PekerjaanOperator::class)->middleware(['auth'])->name('kerja');
Route::get('/produksi/{id}', Produksi::class)->middleware(['auth'])->name('produksi');

