<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();

        return response()->json([
            'success' => true,
            'message' => 'list kelas',
            'data' => $kelas,
        ]);
    }

    public function kelasSantri($slug)
    {
        $kelas = Kelas::where('slug', $slug)->with('santri.nilai')->get();

        if ($kelas->isEmpty() || $kelas->first()->santri->isEmpty()) {
            return response()->json([
                'success' => false,
                'data' => 'tidak ada data'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'list kelas',
            'data' => $kelas,
        ]);
    }
}
