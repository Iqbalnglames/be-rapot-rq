<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SantriController extends Controller
{
    public function index()
    {
        $santri = Santri::with('kelas')->get();

        return response()->json([
            'success' => true,
            'message' => 'list Data Santri',
            'data' => $santri,
        ]);
    }

    public function detail($slug)
    {
        $santri = Santri::findOrFail($slug);

        return response()->json([
            'success' => true,
            'message' => 'data santri atas nama ' . $santri->nama_santri,
            'data' => $santri
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NIS' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'nama_ortu' => 'required',
            'kelas_id' => 'required',
        ], [
            'NIS.required' => 'Nomer Induk Santri Wajib Diisi!',
            'nama.required' => 'Nama Santri Wajib Diisi!',
            'alamat.required' => 'Alamat Wajib Diisi!',
            'nama_ortu.required' => 'Nama Orang Tua Wajib Diisi!',
            'kelas_id.required' => 'Pilih kelas terlebih dahulu!',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $santri = Santri::create([
            'NIS' => $request->NIS,
            'nama' => $request->nama,
            'nama_ortu' => $request->nama_ortu,
            'alamat' => $request->alamat,
            'kelas_id' => $request->kelas_id,
            'slug' => Str::slug($request->nama),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'data berhasil ditambahkan',
            'data' => $santri,
        ]);
    }

    public function update(Request $request, $slug)
    {
        $santri = Santri::where('slug', $slug)->first();

        $validator = Validator::make($request->all(), [
            'NIS' => 'required',
            'nama_santri' => 'required',
            'kelas_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $santri->update([
            'NIS' => $request->NIS,
            'nama_santri' => $request->nama_santri,
            'kelas_id' => $request->kelas_id,
            'rapot_id' => $request->rapot_id,
            'slug' => Str::slug($request->nama_santri),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'data santri berhasil diupdate',
            'data' => $santri,
        ]);
    }

    public function delete($slug)
    {
        $santri = Santri::where('slug', $slug)->first();
        $santri->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data santri atas nama ' . $santri->nama . ' berhasil dihapus',
        ]);
    }
}
