<?php

namespace App\Http\Controllers;

use App\Models\KategoriMapel;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = KategoriMapel::with('mapel')->get();

        return response()->json([
            'success' => true,
            'message' => 'list mapel',
            'data' => $mapel
        ]);
    }

    public function detailMapel($slug)
    {
        $mapelDetail = Mapel::where('slug' , $slug)->first();

        return response()->json([
            'success' => true,
            'message' => 'detail mapel',
            'data' => $mapelDetail
        ]);
    }
}
