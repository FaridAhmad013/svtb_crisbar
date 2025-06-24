<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanProduksiController;
use App\Http\Controllers\Manajamen\KaryawanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProsesProduksiHarian\CatatHasilProduksiController;
use App\Http\Controllers\ProsesProduksiHarian\OpnamePostProductionController;
use App\Http\Controllers\ProsesProduksiHarian\OpnamePreProductionController;
use App\Http\Middleware\RyunnaAuth;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers\Auth')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login_process', [AuthController::class, 'login_process'])->name('auth.login_process');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::get('/debug-middleware', function () {
    return 'Middleware loaded: ' . RyunnaAuth::class;
});

Route::prefix('admin')->middleware([RyunnaAuth::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/edit_profile', [ProfileController::class, 'edit_profile'])->name('profile.edit_profile');
    Route::put('/profile/updatepassword', [ProfileController::class, 'updatePassword'])->name('profile.updatepassword');

    Route::prefix('manajemen')->group(function () {
        Route::resources([
            'karyawan' => KaryawanController::class
        ]);
    });

    Route::prefix('proses_produksi_harian')->group(function () {
        Route::prefix('opname_pre_production')->group(function () {
            Route::get('/', [OpnamePreProductionController::class, 'index'])->name('opname_pre_production.index');
            Route::get('create', [OpnamePreProductionController::class, 'create'])->name('opname_pre_production.create');
            Route::post('store', [OpnamePreProductionController::class, 'store'])->name('opname_pre_production.store');
            Route::delete('destroy/{id}', [OpnamePreProductionController::class, 'destroy'])->name('opname_pre_production.destroy');
            Route::get('sudah_melakukan_opname/{date}', [OpnamePreProductionController::class, 'sudah_melakukan_opname'])->name('opname_pre_production.sudah_melakukan_opname');
            Route::post('preview', [OpnamePreProductionController::class, 'preview'])->name('opname_pre_production.preview');
        });

        Route::prefix('opname_post_production')->group(function () {
            Route::get('/', [OpnamePostProductionController::class, 'index'])->name('opname_post_production.index');
            Route::get('create', [OpnamePostProductionController::class, 'create'])->name('opname_post_production.create');
            Route::get('sudah_melakukan_opname/{date}', [OpnamePostProductionController::class, 'sudah_melakukan_opname'])->name('opname_post_production.sudah_melakukan_opname');
            Route::post('handle_update_qty/{id}', [OpnamePostProductionController::class, 'handle_update_qty'])->name('opname_post_production.handle_update_qty');
        });

        Route::prefix('catat_hasil_produksi')->group(function () {
            Route::get('/', [CatatHasilProduksiController::class, 'index'])->name('catat_hasil_produksi.index');
            Route::post('/store', [CatatHasilProduksiController::class, 'store'])->name('catat_hasil_produksi.store');
            Route::get('/check_sudah_melakukan_catat_hasil_produksi/{date}', [CatatHasilProduksiController::class, 'check_sudah_melakukan_catat_hasil_produksi'])->name('catat_hasil_produksi.check_sudah_melakukan_catat_hasil_produksi');
        });
    });

    Route::prefix('laporan')->group(function () {
        Route::get('laporan_produksi', [LaporanProduksiController::class, 'index'])->name('laporan_produksi.index');
    });


    Route::prefix('datatable')->group(function(){
        Route::post('karyawan', [KaryawanController::class, 'datatable'])->name('datatable.karyawan');
        Route::post('opname_pre_production', [OpnamePreProductionController::class, 'datatable'])->name('datatable.opname_pre_production');
        Route::post('opname_post_production', [OpnamePostProductionController::class, 'datatable'])->name('datatable.opname_post_production');
        Route::post('laporan_produksi', [LaporanProduksiController::class, 'datatable'])->name('datatable.laporan_produksi');
    });
});


