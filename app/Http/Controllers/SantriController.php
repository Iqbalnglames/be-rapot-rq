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

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'NIS' => 'required',
            'nama_santri' => 'required',
            'kelas_id' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([$validator->errors(), 422]);
        }

        $santri = Santri::create([
            'NIS' => $request->NIS,
            'nama_santri' => $request->nama_santri,
            'kelas_id' => $request->kelas_id,
            'slug' => Str::slug($request->nama_santri),
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

        $validator = Validator::make($request->all(),[
            'NIS' => 'required',
            'nama_santri' => 'required',
            'kelas_id' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        $santri->update([
            'NIS' => $request->NIS,
            'nama_santri' => $request->nama_santri,
            'kelas_id' => $request->kelas_id,
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
    }
}
