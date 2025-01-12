<?php

use App\Http\Controllers\AsatidzahController;
use App\Http\Controllers\CatatanSantriController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RapotController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user()->load('roles', 'mapels.kelas', 'kelas');
        return response()->json($user);
    });
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::get('/tanda-tangan/{filename}', function ($filename) {
    $imagePath = public_path('storage/tanda-tangan/' . $filename);
    if (file_exists($imagePath)) {
        return response()->file($imagePath);
    } else {
        return response('Image not found', 404);
    }
});
Route::get('/asatidzah', [UserController::class, 'index']);
Route::get('/user/{user:slug}/detail', [UserController::class, 'detail']);
Route::get('/user/{user:slug}/edit', [UserController::class, 'edit']);
Route::get('/{user:slug}/role', [AsatidzahController::class, 'detailRole']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/{user}/activate', [UserController::class, 'activateAccount']);
Route::post('/{user}/update', [UserController::class, 'update']);
Route::get('/{user:slug}/delete', [UserController::class, 'delete']);
Route::post('/{user:slug}/update-role', [AsatidzahController::class, 'updateRole']);
Route::post('/{user:slug}/update-signature', [AsatidzahController::class, 'signatureUpload']);
Route::post('/{user:slug}/update-mapel-ajar', [AsatidzahController::class, 'updateMapelAjar']);
Route::get('/{user:slug}/mapel-ajar', [AsatidzahController::class, 'detailMapelAjar']);
Route::get('/show-kepsek', [AsatidzahController::class, 'showKepSek']);

Route::get('/mapel', [MapelController::class, 'indexMapel']);
Route::get('/kategori-mapel', [MapelController::class, 'index']);
Route::post('/kategori-mapel', [MapelController::class, 'storeKategori']);
Route::post('/mapel', [MapelController::class, 'store']);
Route::get('/mapel/{mapel:slug}', [MapelController::class, 'detailMapel']);

Route::get('/santri', [SantriController::class, 'index']);
Route::get('/santri/{santri:kelas}', [SantriController::class, 'indexSantriKelasBased']);
Route::post('/santri/add', [SantriController::class, 'create']);
Route::get('/santri/{santri:slug}/detail', [SantriController::class, 'detail']);
Route::put('/santri/{santri:slug}/update', [SantriController::class, 'update']);
Route::get('/santri/{santri:slug}/delete', [SantriController::class, 'delete']);

Route::get('/rapot/{rapot:slug}', [RapotController::class, 'index']);
Route::post('/rapot/add/{rapot:slug}', [RapotController::class, 'store']);
Route::post('/rapot/{rapot}/update', [RapotController::class, 'update']);
Route::get('/rapot/{rapot}/delete', [RapotController::class, 'delete']);

Route::get('/nilai/{nilai:kelas}', [NilaiController::class, 'indexNilai']);
Route::get('/nilai/mapel/{nilai:slug}', [NilaiController::class, 'detailMapel']);

Route::get('/kelas', [KelasController::class, 'index']);
Route::get('/kelas/{kelas:slug}', [KelasController::class, 'kelasSantri']);

Route::get('/role', [RoleController::class, 'index']);
Route::post('/role', [RoleController::class, 'store']);

Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index']);
Route::post('/tahun-ajaran', [TahunAjaranController::class, 'store']);

Route::post('/{catatan:slug}/simpan-catatan', [CatatanSantriController::class, 'store']);
Route::post('/{catatan:slug}/update-catatan', [CatatanSantriController::class, 'update']);
