<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();

        return response()->json([
            'message' => 'list role',
            'data' => $role,
        ], 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_role' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        Role::create([
            'nama_role' => $request->nama_role,
            'slug' => Str::slug($request->nama_role),
        ]);

        return response()->json(['message' => 'berhasil menambahkan role'], 200);
    }
}
