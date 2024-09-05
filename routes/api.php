<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RapotController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
   Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/mapel', [MapelController::class, 'index']);
Route::get('/mapel/{mapel:slug}', [MapelController::class, 'detailMapel']);

Route::get('/santri', [SantriController::class, 'index']);
Route::post('/santri/add', [SantriController::class, 'create']);
Route::get('/santri/{santri:slug}/detail', [SantriController::class, 'detail']);
Route::put('/santri/{santri:slug}/update', [SantriController::class, 'update']);
Route::delete('/santri/{santri:slug}/delete', [SantriController::class, 'delete']);

Route::get('/rapot/{rapot:slug}', [RapotController::class, 'index']);
Route::post('/rapot/add/{rapot:slug}', [RapotController::class, 'store']);
Route::get('/rapot/{rapot}/update', [RapotController::class, 'update']);
Route::get('/rapot/{rapot}/delete', [RapotController::class, 'delete']);

Route::get('/nilai', [NilaiController::class, 'indexNilai']);
Route::get('/nilai/mapel/{nilai:slug}', [NilaiController::class, 'detailMapel']);

Route::get('/kelas', [KelasController::class, 'index']);
Route::get('/kelas/{kelas:slug}', [KelasController::class, 'kelasSantri']);


