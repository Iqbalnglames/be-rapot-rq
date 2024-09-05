<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Rapot;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RapotController extends Controller
{
    public function index($slug)
    {
        $santri = Santri::with(['kelas', 'nilai.mapel', 'nilai.semester'])->where('slug', $slug)->first();

        return response()->json([
            'success' => true,
            'message' => 'data rapot santri',
            'data' => $santri,
        ]);
    }

    public function store(Request $request, $slug)
    {
        $santri = Santri::where('slug', $slug)->firstOrFail();
        $validateNumeric = 'required|numeric';
        $validator = Validator::make($request->all(), [
            'tugas_1' => $validateNumeric,
            'tugas_2' => $validateNumeric,
            'tugas_3' => $validateNumeric,
            'UTS' => $validateNumeric,
            'UAS' => $validateNumeric,
            'mapel_id' => 'required|exists:mapels,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $nilaiUas = round(($request->tugas_1 * 0.1) + ($request->tugas_1 * 0.1) + ($request->tugas_3 * 0.1) + ($request->UTS * 0.2) + ($request->UAS * 0.5));

        // Buat data Nilai
        $nilai = Nilai::create([
            'kelas_id' => $request->kelas_id,
            'semester_id' => $request->semester_id,
            'tugas_1' => $request->tugas_1,
            'tugas_2' => $request->tugas_2,
            'tugas_3' => $request->tugas_3,
            'UTS' => $request->UTS,
            'UAS' => $nilaiUas,
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
        $nilai = Nilai::findOrFail($id);

        $validateNumeric = 'required|numeric';
        $validator = Validator::make($request->all(), [
            'tugas_1' => $validateNumeric,
            'tugas_2' => $validateNumeric,
            'tugas_3' => $validateNumeric,
            'UTS' => $validateNumeric,
            'UAS' => $validateNumeric,
            'mapel_id' => 'required|exists:mapels,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $nilaiUas = round(($request->tugas_1 * 0.1) + ($request->tugas_1 * 0.1) + ($request->tugas_3 * 0.1) + ($request->UTS * 0.2) + ($request->UAS * 0.5));

        $nilai->update([
            'kelas_id' => $request->kelas_id,
            'semester_id' => $request->semester_id,
            'tugas_1' => $request->tugas_1,
            'tugas_2' => $request->tugas_2,
            'tugas_3' => $request->tugas_3,
            'UTS' => $request->UTS,
            'UAS' => $nilaiUas,
            'mapel_id' => $request->mapel_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil diupdate',
            'data' => $nilai
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
