<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;

// Route bawaan Laravel (halaman sambutan)
Route::get('/', function () {
    return view('welcome');
});

// Daftar buku + pencarian (?cari=...)
Route::get('/buku', [BukuController::class, 'index']);

// Detail buku berdasarkan kode
Route::get('/buku/{kode}', [BukuController::class, 'show']);