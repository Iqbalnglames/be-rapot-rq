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
        $santri = Santri::with(['kelas', 'nilai.mapel.kelas', 'nilai.semester'])->where('slug', $slug)->first();

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
            // 'tugas_1' => $validateNumeric,
            // 'tugas_2' => $validateNumeric,
            // 'tugas_3' => $validateNumeric,
            // 'UTS' => $validateNumeric,
            // 'UAS' => $validateNumeric,
            'kkm' => $validateNumeric,
            'mapel_id' => 'required',
            'tahun_ajaran_id' => $validateNumeric,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $nilaiTotal = round(($request->tugas_1 * 0.1) + ($request->tugas_2 * 0.1) + ($request->tugas_3 * 0.1) + ($request->UTS * 0.2) + ($request->UAS * 0.5));
        $isRemed = $nilaiTotal < $request->kkm ? true : false;
        $nilaiUasFinal = $isRemed ? $request->kkm : $nilaiTotal;

        // Buat data Nilai
        $nilai = Nilai::create([
            'kelas_id' => $request->kelas_id,
            'semester_id' => $request->semester_id,
            'tugas_1' => $request->tugas_1,
            'tugas_2' => $request->tugas_2,
            'tugas_3' => $request->tugas_3,
            'UTS' => $request->UTS,
            'UAS' => $request->UAS,
            'total' => $nilaiUasFinal,
            'isRemed' => $isRemed,
            'mapel_id' => $request->mapel_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
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
            // 'tugas_1' => $validateNumeric,
            // 'tugas_2' => $validateNumeric,
            // 'tugas_3' => $validateNumeric,
            // 'UTS' => $validateNumeric,
            // 'UAS' => $validateNumeric,
            'kkm' => $validateNumeric,
            'mapel_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // dd($request->tugas_3);

        $nilaiTotal = round(((int)$request->tugas_1 * 0.1) + ((int)$request->tugas_2 * 0.1) + ((int)$request->tugas_3 * 0.1) + ((int)$request->UTS * 0.2) + ((int)$request->UAS * 0.5));
        $isRemed = $nilaiTotal < (int)$request->kkm ? true : false;
        $nilaiUasFinal = $isRemed ? (int)$request->kkm : $nilaiTotal;

        $nilai->update([
            'kelas_id' => $request->kelas_id,
            'semester_id' => $request->semester_id,
            'tugas_1' => $request->tugas_1,
            'tugas_2' => $request->tugas_2,
            'tugas_3' => $request->tugas_3,
            'UTS' => $request->UTS,
            'UAS' => $request->UAS,
            'total' => $nilaiUasFinal,
            'isRemed' => $isRemed,
            'mapel_id' => $request->mapel_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
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
