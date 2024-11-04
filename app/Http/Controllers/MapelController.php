<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriMapel;
use Illuminate\Support\Facades\Validator;

class MapelController extends Controller
{
    public function indexMapel()
    {
        $mapel = Mapel::with('kelas')->get();

        return response()->json([
            'success' => true,
            'message' => 'list mapel',
            'data' => $mapel
        ]);
    }

    public function index()
    {
        $mapel = KategoriMapel::with('mapel.kelas')->get();

        return response()->json([
            'success' => true,
            'message' => 'list mapel',
            'data' => $mapel
        ]);
    }

    public function store(Request $request)
    {
        $kelasId = json_decode($request->kelas_id);

        $validate = Validator::make($request->all(), [
            'nama_mapel' => 'required | unique:mapels',
            'kategori_mapel_id' => 'required',
            'kelas_id' =>  'required'
        ], [
            'nama_mapel.unique' => 'mapel yang anda masukkan sudah ada',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $mapel_id = Mapel::create([
            'nama_mapel' => $request->nama_mapel,
            'slug' => Str::slug($request->nama_mapel),
            'kategori_mapel_id' => $request->kategori_mapel_id
        ]);

        $mapelKelas = Mapel::find($mapel_id->id);

        $mapelKelas->kelas()->sync($kelasId);

        return response()->json(['message' => 'mapel berhasil disimpan'], 200);
    }

    public function storeKategori(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kategori_mapel' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        KategoriMapel::create([
            'kategori_mapel' => $request->kategori_mapel,
            'slug' => Str::slug($request->kategori_mapel),
        ]);

        return response()->json(['message' => 'mapel berhasil disimpan'], 200);
    }
    public function detailMapel($slug)
    {
        $mapelDetail = Mapel::with('kelas')->where('slug', $slug)->first();

        return response()->json([
            'success' => true,
            'message' => 'detail mapel',
            'data' => $mapelDetail
        ]);
    }
}
