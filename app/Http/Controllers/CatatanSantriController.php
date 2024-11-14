<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CatatanSantri;
use Illuminate\Support\Facades\Validator;

class CatatanSantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'catatan' => 'required',
            'sakit' => 'required',
            'izin' => 'required',
            'alfa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        CatatanSantri::create([
            'user_id' => $request->user_id,
            'catatan' => $request->catatan,
            'sakit' => $request->sakit,
            'izin' => $request->izin,
            'alfa' => $request->alfa,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'catatan berhasil disimpan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(CatatanSantri $catatanSantri)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CatatanSantri $catatanSantri)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->first();

        $catatan = CatatanSantri::where('santri_id', $user->id)->first();

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'catatan' => 'required',
            'sakit' => 'required',
            'izin' => 'required',
            'alfa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $catatan->update([
            'catatan' => $request->catatan,
            'catatan' => $request->catatan,
            'sakit' => $request->sakit,
            'izin' => $request->izin,
            'alfa' => $request->alfa,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'catatan berhasil disimpan'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CatatanSantri $catatanSantri)
    {
        //
    }
}
