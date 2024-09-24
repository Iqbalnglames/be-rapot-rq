<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\ActivateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        $user->makeHidden(['password', 'username']);

        return response()->json([
            'success' => true,
            'message' => 'list data asatidzah',
            'data' => $user,
        ]);
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required | unique:users',
            'email' => 'required | email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $data = [
            'subject' => 'Aktivasi Akun Asatidzah',
            'title' => 'Aktivasi Akun ' . $user->username,
            'body' => 'ada akun baru dengan username ' . $user->username . ', periksa dan aktivasi jika data valid'
        ];

        Mail::to('mi06514@gmail.com')->send(new ActivateMail($data));

        return response()->json([
            'success' => true,
            'message' => 'sukses mendaftarkan user',
            'token_type' => 'Bearer',
            'data' => $user,
        ]);
    }

    public function activateAccount(Request $request, $slug)
    {
        $validate = Validator::make($request->all(), [
            'isActivate' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = User::where('slug', $slug)->first();

        $user->update([
            'isActivate' => $request->isActive
        ]);

        $data = [
            'subject' => 'Aktivasi Akun Antum',
            'title' => 'Aktivasi Akun ' . $user->username,
            'body' => 'Alhamdulillah, akun antum dengan username ' . $user->username . 'sudah bisa digunakan'
        ];

        Mail::to($user->email)->send(new ActivateMail($data));

        return response()->json([
            'success' => true,
            'message' => 'akun berhasil di aktifkan'
        ]);
    }

    public function update(Request $request, $slug)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required | unique:users',
            'email' => 'required | email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = User::where('slug', $slug)->first();

        $user->update([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isActive' => $user->isActive,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'sukses mengupdate user',
            'token_type' => 'Bearer',
            'data' => $user,
        ]);
    }

    public function updateRole(Request $request, $slug)
    {
        $validate = Validator::make($request->all(), [
            'role_id' => 'required | array',
            'user_id' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        $user = User::where('slug', $slug)->first();

        $user->roles()->sync($request->role_id);

        return response()->json([
            'success' => true,
            'message' => 'sukses mengupdate role user',
            'data' => $user,
        ]);
    }

    public function login(Request $request)
    {
        
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'isi username anda',
            'password.required' => 'isi password anda',
        ]);
        
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }
        
        $user = User::where('username', $request->username)->firstOrFail();
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        } elseif($user->isActive === 0){
            return response()->json([
                'message' => 'akun antum belum diaktivasi'
            ], 401);
        }

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

        if ($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',
            ]);
        }
    }
}
