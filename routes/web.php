<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\DataUjiFungsiController;
use App\Http\Controllers\GaransiController;
use App\Http\Controllers\InstalasiAlatController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PenjadwalanController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SopAlatController;
use App\Http\Controllers\TemplateUjiFungsiController;

use App\Http\Middleware\Authenticate;

Route::get('cek-auth', [AuthController::class, 'authenticate'])->name('cek-auth');
Route::post('logout-auth', [AuthController::class, 'logout'])->name('logout');


Route::middleware([Authenticate::class])->group(function () {

    Route::get('/', function () {
        $data = \App\Models\Pengaturan::first();
        return view('welcome', [
            'data' => $data,
        ]);
    });


    // create me route login


    Route::resource('alat', AlatController::class)->names('alat');
    Route::resource('teknisi', TeknisiController::class)->names('teknisi');
    Route::resource('rumah-sakit', RumahSakitController::class)->names('rumah-sakit');
    Route::resource('data-garansi', GaransiController::class)->names('data-garansi');
    Route::resource('sop-alat', SopAlatController::class)->names('sop-alat');
    Route::resource('data-uji-fungsi', DataUjiFungsiController::class)->names('data-uji-fungsi');
    Route::get('form-uji-fungsi', [DataUjiFungsiController::class, 'form_qc'])->name('form-qc');
    Route::get('validate-no-seri', [DataUjiFungsiController::class, 'validate_no_seri'])->name('validate-no-seri');
    Route::post('upload-foto-qc', [DataUjiFungsiController::class, 'upload_foto'])->name('upload-foto-qc');
    // Route::resource('uji-fungsi', UjiFungsiController::class)->names('uji-fungsi');
    Route::resource('template-uji-fungsi', TemplateUjiFungsiController::class)->names('template-uji-fungsi');
    Route::resource('instalasi-alat', InstalasiAlatController::class)->names('instalasi-alat');
    Route::get('get-alat/{id}', [InstalasiAlatController::class, 'get_alat'])->name('get-alat');
    Route::get('data-perusahaan', [PerusahaanController::class, 'index'])->name('perusahaan');
    Route::post('perusahaan/store', [PerusahaanController::class, 'store'])->name('perusahaan.store');
    Route::delete('perusahaan/delete/{id}', [PerusahaanController::class, 'destroy'])->name('perusahaan.delete');

    Route::post('upload-foto-instalasi', [InstalasiAlatController::class, 'upload_foto_instalasi'])->name('upload-foto');
    Route::post('upload-file-lampiran', [InstalasiAlatController::class, 'upload_file_lampiran'])->name('upload-file-lampiran');
    Route::get('download-file-lampiran/{id}', [InstalasiAlatController::class, 'download_file_lampiran'])->name('download-file-lampiran');

    Route::resource('penjadwalan', PenjadwalanController::class)->names('penjadwalan');
    Route::get('kalender-teknisi', [PenjadwalanController::class, 'kalender_teknisi'])->name('kalender-teknisi');

    Route::resource('pengaturan', PengaturanController::class)->names('pengaturan');
    Route::get('download-qrcode/{id}', [InstalasiAlatController::class, 'download_qrcode'])->name('download-qrcode');
    Route::resource('services', PerbaikanController::class)->names('services');

    Route::get('get-uji-fungsi/{id}', [InstalasiAlatController::class, 'get_uji_fungsi'])->name('get-uji-fungsi');
});
