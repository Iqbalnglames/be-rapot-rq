<?php

use App\Http\Controllers\KelasController;
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

Route::get('/santri', [SantriController::class, 'index']);
Route::post('/santri/add', [SantriController::class, 'create']);
Route::get('/santri/{santri:slug}/detail', [SantriController::class, 'detail']);
Route::put('/santri/{santri:slug}/update', [SantriController::class, 'update']);
Route::delete('/santri/{santri:slug}/delete/', [SantriController::class, 'delete']);

Route::get('/rapot/{rapot:slug}', [RapotController::class, 'index']);
Route::post('/rapot/add/{rapot:slug}', [RapotController::class, 'store']);
Route::get('/rapot/{rapot}/detail', [RapotController::class, 'detail']);
Route::get('/rapot/{rapot}/edit', [RapotController::class, 'update']);
Route::get('/rapot/{rapot}/delete', [RapotController::class, 'update']);

Route::get('/kelas', [KelasController::class, 'index']);


