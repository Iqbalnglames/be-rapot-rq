<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Rapot;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RapotController extends Controller
{
    public function index($slug)
    {
        $santri = Santri::where('slug', $slug)->first();

        if(!$santri || !$santri->rapot_id)
        {
            return response()->json([
                'success' => false,
                'message' => 'data rapot tidak ditemukan',
            ]);
        }

        $rapots = Rapot::with(['nilai', 'semester', 'user'])->find($santri->rapot_id);

        return response()->json([
            'success' => true,
            'message' => 'list data rapot santri',
            'data' => $rapots
        ]);
    }

    public function store(Request $request, $slug)
    {
        $santri = Santri::where('slug', $slug)->firstOrFail();

        $request->validate([
            'tugas_1' => 'required|numeric',
            'tugas_2' => 'required|numeric',
            'tugas_3' => 'required|numeric',
            'UTS' => 'required|numeric',
            'UAS' => 'required|numeric',
            'mapel_id' => 'required|exists:mapels,id'
        ]);
    
        // Buat data Nilai
        $nilai = Nilai::create([
            'tugas_1' => $request->tugas_1,
            'tugas_2' => $request->tugas_2,
            'tugas_3' => $request->tugas_3,
            'UTS' => $request->UTS,
            'UAS' => $request->UAS,
            'mapel_id' => $request->mapel_id,
        ]);

        $rapot = Rapot::create([
            'santri_id' => $santri->id,
            'nilai_id' => $nilai->id,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil ditambahkan',
            'data' => $rapot
        ]);
    }

    public function update(Request $request, $id)
    {
        $nilai = Rapot::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'santri_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $nilai->update([
            'santri_id' => $request->santri_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'nilai berhasil diperbarui',
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $nilai = Nilai::findOrFail($id);

        $nilai->delete();

        return response()->json([
            'success' => true,
            'message' => 'nilai berhasil direset',
        ]);
    }
}
