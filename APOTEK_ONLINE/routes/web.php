<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\LaporanController;

// =========================
// AUTH ROUTES
// =========================

Route::get('/', fn () => redirect('/login'));

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================
// PROTECTED ROUTES
// =========================

Route::middleware('auth')->group(function () {

    // =========================
    // ADMIN ROUTES
    // =========================

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Obat
        Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
        Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
        Route::post('/obat/store', [ObatController::class, 'store'])->name('obat.store');
        Route::get('/obat/edit/{id}', [ObatController::class, 'edit'])->name('obat.edit');
        Route::put('/obat/update/{id}', [ObatController::class, 'update'])->name('obat.update');
        Route::delete('/obat/delete/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

        // Pesanan
        Route::get('/pesanan', [PesananController::class, 'pesananMasuk'])->name('pesanan.masuk');
        Route::get('/pesanan/{id}/status/{status}', [PesananController::class, 'ubahStatus'])->name('pesanan.ubah_status');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        // Form Komplain
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/komplain', [AdminController::class, 'kotakKomplain'])->name('admin.komplain');
        Route::post('/admin/komplain/{id}/balas', [AdminController::class, 'balasKomplain'])->name('admin.balas_komplain');
    });

    // =========================
    // USER ROUTES
    // =========================

    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('user.dashboard');

        // Obat
        Route::get('/obat', [UserController::class, 'daftarObat'])->name('user.daftar_obat');

        // Pemesanan
        Route::get('/pesan-obat/{id}', [PesananController::class, 'formPesan'])->name('user.form_pesan_obat');
        Route::post('/pesan-obat/{id}', [PesananController::class, 'simpanPesanan'])->name('user.simpan_pesanan');

        // Pesanan Saya
        Route::get('/pesanan', [UserController::class, 'pesananSaya'])->name('user.pesanan');
        Route::get('/pesanan', [UserController::class, 'pesananSaya'])->name('user.pesanan_saya');
        Route::put('/pesanan/{id}/batal', [UserController::class, 'batalkanPesanan'])->name('user.batalkan_pesanan');
        Route::get('/pesanan/{id}', [UserController::class, 'detailPesanan'])->name('user.detail_pesanan');

        // Form Komplain
        Route::post('/user/kirim-komplain', [UserController::class, 'kirimKomplain'])->name('user.kirim_komplain');
    });

});

