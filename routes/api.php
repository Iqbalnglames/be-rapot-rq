<?php

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
Route::post('/santri/update/{santri:slug}', [SantriController::class, 'update']);
