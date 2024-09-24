<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $data = TahunAjaran::all();

        return response()->json(['succes' => true, 'message' => 'list tahun ajaran', 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tajar' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        TahunAjaran::create([
            'tajar' => $request->tajar,
        ]);

        return response()->json(['success' => true, 'message' => 'tahun ajaran berhasil di simpan']);
    }
}
