<?php

use App\Http\Controllers\StudioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Jalur Utama & Otentikasi
|--------------------------------------------------------------------------
*/

// Landing Page Publik (Tidak perlu login)
Route::get('/', [StudioController::class, 'landing'])->name('landing');

// Dibungkus dengan middleware 'guest' agar user yang SUDAH LOGIN 
// tidak bisa melihat halaman login/register lagi.
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { 
        return view('auth.login'); 
    })->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', function () { 
        return view('auth.register'); 
    })->name('register');
    
    Route::post('/register', [AuthController::class, 'register']);

    // Google Login Routes
    Route::get('/auth/google', [App\Http\Controllers\GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [App\Http\Controllers\GoogleAuthController::class, 'callback'])->name('google.callback');
});

// Logout tidak boleh di dalam 'guest', karena hanya user login yang bisa logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| Web Routes - Sisi User / Pelanggan
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-studio', [StudioController::class, 'index'])->name('user.dashboard');
    Route::get('/paket-foto', [StudioController::class, 'paketFoto']); 
    Route::get('/galeri', [StudioController::class, 'galeri']); 
    Route::get('/booking/{id}', [StudioController::class, 'formBooking']); 
    Route::post('/booking/simpan', [StudioController::class, 'simpanBooking']); 
    Route::get('/riwayat-pemesanan', [StudioController::class, 'riwayatPemesanan']); 
    Route::post('/riwayat-pemesanan/upload/{id}', [StudioController::class, 'uploadBukti']); 
    Route::delete('/riwayat-pemesanan/hapus/{id}', [StudioController::class, 'hapusPemesanan']);
    Route::get('/profil', [StudioController::class, 'profil']);
    Route::post('/profil/update', [StudioController::class, 'updateProfil']);
    Route::delete('/profil/hapus-foto', [StudioController::class, 'hapusFotoProfil']);
});

/*
|--------------------------------------------------------------------------
| Sisi Admin
|--------------------------------------------------------------------------
*/
// Rantai keamanan ganda: Pastikan login DULU ('auth'), baru cek peran ('admin')
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Mengelola Paket
    Route::get('/paket', [AdminController::class, 'paket']); 
    Route::post('/paket', [AdminController::class, 'storePaket']); 
    Route::put('/paket/{id}', [AdminController::class, 'updatePaket']);
    Route::delete('/paket/{id}', [AdminController::class, 'destroyPaket']);

    // Verifikasi Pembayaran
    Route::get('/verifikasi-pembayaran', [AdminController::class, 'verifikasiPembayaran']);
    Route::post('/verifikasi-pembayaran/{id}/{status}', [AdminController::class, 'updateStatusPembayaran'])->name('admin.pembayaran.update');
    
    // Laporan
    Route::get('/laporan', [AdminController::class, 'laporan']);
    Route::get('/laporan/excel', [AdminController::class, 'eksporExcel']);
    Route::get('/laporan/pdf', [AdminController::class, 'eksporPdf']);
    
    // Latar Belakang / Kategori
    Route::get('/latar-belakang', [AdminController::class, 'latarBelakang']);
    Route::post('/latar-belakang', [AdminController::class, 'storeLatarBelakang']);
    Route::put('/latar-belakang/{id}', [AdminController::class, 'updateLatarBelakang']);
    Route::delete('/latar-belakang/{id}', [AdminController::class, 'destroyLatarBelakang']);
    
    // Galeri
    Route::post('/galeri', [AdminController::class, 'storeGaleri']);
    Route::delete('/galeri/{id}', [AdminController::class, 'destroyGaleri']);
});

Route::get('/jalankan-paksa', function() {
    if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'foto_profil')) {
        \Illuminate\Support\Facades\Schema::table('users', function ($table) {
            $table->string('foto_profil')->nullable();
        });
        return 'Kolom foto_profil berhasil DITAMBAHKAN SECARA PAKSA!';
    }
    return 'Kolom foto_profil SUDAH ADA. Masalahnya bukan di database.';
});