<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\master\PasienController;

// Route::get('/anggota', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//AUTH
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('tambah-pasien', [PasienController::class, 'store']);
    Route::get('pasien-list', [PasienController::class, 'index']);
    Route::post('post-keperawatan', [PasienController::class, 'postPemeriksaanPerawat']);
    Route::get('pemeriksaan/{uuid}', [PasienController::class, 'getPemeriksaan']);
    Route::put('post-dokter', [PasienController::class, 'putPemeriksaanDokter']);
});

