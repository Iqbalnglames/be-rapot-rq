<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AsatidzahController extends Controller
{
    public function signatureUpload(Request $request, $slug)
    {
        Validator::make($request->all(), [
            'tanda_tangan' => 'required|image'
        ]);

        $image = $request->file('tanda_tangan');
        $image->storeAs('public/tanda-tangan', $image->hashName());

        $user = User::where('slug', $slug)->first();

        $user->update([
            'tanda_tangan' => $image->hashName(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'tanda tangan berhasil disimpan'
        ]);
    }

    public function updateRole(Request $request, $slug)
    {
        $roleId = json_decode($request->role_id);

        $validate = Validator::make($request->all(), [
            'role_id' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = User::where('slug', $slug)->first();

        $user->roles()->sync($roleId);
        $user->update([
            'kelas_id' => $request->kelas_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'sukses mengupdate role user',
            'data' => $user,
        ]);
    }

    public function showKepSek()
    {
        $kepsek = User::whereHas('roles', function ($query) {
            $query->where('nama_role', 'Kepala Sekolah');
        })->first();

        return response()->json([
            'success' => true,
            'data' => $kepsek
        ]);
    }

    public function detailRole($slug)
    {

        $user = User::with('roles')->where('slug', $slug)->first();

        return response()->json([
            'success' => true,
            'message' => 'role user',
            'data' => $user,
        ]);
    }

    public function detailMapelAjar($slug)
    {

        $user = User::with('mapels')->where('slug', $slug)->first();

        return response()->json([
            'success' => true,
            'message' => 'mapel ajar user',
            'data' => $user,
        ]);
    }

    public function updateMapelAjar(Request $request, $slug)
    {
        $mapelId = json_decode($request->mapel_id);
        $validate = Validator::make($request->all(), [
            'mapel_id' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = User::where('slug', $slug)->first();

        $user->mapels()->sync($mapelId);

        return response()->json([
            'success' => true,
            'message' => 'sukses mengupdate mapel user',
            'data' => $user,
        ]);
    }
}
