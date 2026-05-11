<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AnggotaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK ---
Route::get('/', function () {
    return view('halamanutama');
})->name('home');

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

Route::get('/tentang', function () {
    return view('public.tentangs.tentang'); 
})->name('tentangs.tentang');

Route::get('/galeri/{id_kegiatan}', [GaleriController::class, 'show'])->name('galeri.show');
Route::post('/galeri/{id}/view', [GaleriController::class, 'incrementViews']);

// --- 2. GUEST AREA (Login & Register) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// --- 3. AUTH AREA (Wajib Login) ---
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- FITUR LAYANAN USER (Warga) ---
    // Nama rute otomatis diawali: pengaduan.
    Route::prefix('layanan')->name('pengaduan.')->group(function () {
        Route::get('/pengaduan', function () {
            return view('public.layanan.layanan');
        })->name('create');
        
        Route::get('/riwayat', [PengaduanController::class, 'index'])->name('index');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('store');
        
        // PERBAIKAN: Menambahkan rute show agar route('pengaduan.show') bisa ditemukan
        Route::get('/riwayat/{id}', [PengaduanController::class, 'show'])->name('show');
    });

    // --- AREA ADMIN ---
    // Nama rute otomatis diawali: admin.
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
        Route::get('/halamanutama', [AuthController::class, 'adminDashboard'])->name('halamanutama');

        // Kelola Galeri (admin.galeri.index)
        Route::prefix('kelola_galeri')->name('galeri.')->group(function () {
            Route::get('/', [GaleriController::class, 'indexGaleri'])->name('index');
            Route::get('/create', [GaleriController::class, 'createGaleri'])->name('create');
            Route::post('/store', [GaleriController::class, 'storeGaleri'])->name('store');
            Route::get('/{galeri}/edit', [GaleriController::class, 'editGaleri'])->name('edit');
            Route::put('/{galeri}', [GaleriController::class, 'updateGaleri'])->name('update');
            Route::delete('/{galeri}', [GaleriController::class, 'destroyGaleri'])->name('destroy');
        });

        // Kelola Pengaduan Admin (admin.pengaduan.index)
        Route::prefix('pengaduan')->name('pengaduan.')->group(function () {
            Route::get('/', [PengaduanController::class, 'indexAdmin'])->name('index');
            Route::get('/{id}', [PengaduanController::class, 'show'])->name('show');
            Route::delete('/{id}', [PengaduanController::class, 'destroy'])->name('destroy');
            Route::put('/{id}/status', [PengaduanController::class, 'updateStatus'])->name('update-status');
        });

        // Kelola Anggota (admin.kelola-anggota.index)
        Route::resource('kelola-anggota', AnggotaController::class)->parameters([
            'kelola-anggota' => 'anggota'
        ]);

        // Kelola User (admin.kelola-user.index)
        Route::prefix('kelola-user')->name('kelola-user.')->group(function () {
            Route::get('/', [AuthController::class, 'indexUser'])->name('index');
            Route::get('/create', [AuthController::class, 'createUser'])->name('create');
            Route::post('/store', [AuthController::class, 'storeUser'])->name('store');
            Route::get('/{user}/edit', [AuthController::class, 'editUser'])->name('edit');
            Route::put('/{user}', [AuthController::class, 'updateUser'])->name('update');
            Route::delete('/{user}', [AuthController::class, 'destroyUser'])->name('destroy');
        });

    });
});