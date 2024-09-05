<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Santri;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function indexNilai()
    {
        $santri = Santri::with(['kelas', 'nilai.mapel', 'nilai.semester'])->get();

        return response()->json([
            'success' => true,
            'message' => 'list Data Santri',
            'data' => ['santri' => $santri],
        ]);
    }

    public function detailMapel($slug)
    {
         $mapel = Mapel::where('slug', $slug)->first();

         if (!$mapel) {
             return response()->json([
                 'success' => false,
                 'message' => 'Mapel ' . $slug .' tidak ditemukan ' ,
             ], 404);
         }
 
         $santri = Santri::whereHas('nilai', function($query) use ($mapel){
            $query->where('mapel_id' , $mapel->id);
         })->with(['nilai' => function ($query) use ($mapel){
            $query->where('mapel_id', $mapel->id);
         }, 'nilai.mapel'])->get();
 
         return response()->json([
             'success' => true,
             'message' => 'Data nilai santri untuk mapel ' . $mapel->nama_mapel,
             'data' => $santri
         ]);

    }
}
