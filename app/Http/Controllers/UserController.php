<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required | unique:users',
            'email' => 'required | email',
            'password' => 'required',
        ]);

        if($validate->fails())
        {
            return response()->json($validate->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->email),
            // 'isActive' => [$request->isActive == '1' ? 1 : 0],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'sukses mendaftarkan user',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'data' => $user,
        ]);
    }
    
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('username', $request->username)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request)
    {
       $removeToken = $request->user()->tokens()->delete();

       if($removeToken)
       {
        return response()->json([
            'success' => true,
            'message' => 'Logout Success!',
        ]);
       }
    }

}
