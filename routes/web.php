<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExcelUploadController;
use App\Http\Controllers\KlusterController;
use App\Http\Controllers\HasilClusteringController;
use App\Http\Controllers\VisualisasiDataController;

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Dashboard (Butuh Login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// Halaman Import Data
Route::get('/importdata', function () {
    return view('importdata');
})->middleware('auth')->name('importdata');

// Halaman Tentukan Kluster
Route::get('/tentukancluster', function () {
    return view('tentukancluster');
})->middleware('auth')->name('tentukancluster');

// Halaman Hasil Clustering
Route::get('/hasilclustering', function () {
    return view('hasilclustering');
})->middleware('auth')->name('hasilclustering');

Route::post('/upload-excel', [ExcelUploadController::class, 'upload'])->name('upload.excel');
Route::post('import', [ExcelUploadController::class, 'import'])->name('excel.import');
Route::get('/import', [ExcelUploadController::class, 'index'])->name('excel.index'); 
Route::post('/dtks/reset', [ExcelUploadController::class, 'reset'])->name('dtks.reset');

Route::get('/kluster', [KlusterController::class, 'index'])->name('tentukancluster');
Route::post('/kluster/proses', [KlusterController::class, 'proses'])->name('kluster.proses');

Route::get('/hasil-clustering', [HasilClusteringController::class, 'index'])->name('hasilclustering');

Route::get('/export-klasterisasi', [HasilClusteringController::class, 'export'])->name('export.klasterisasi');

Route::get('/visualisasidata', [HasilClusteringController::class, 'visualisasi'])->name('visualisasidata');
