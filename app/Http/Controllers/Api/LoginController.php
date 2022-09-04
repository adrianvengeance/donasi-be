<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * login
     *
     * @param mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $donatur = Donatur::where('email', $request->email)->first();
        if (!$donatur || !Hash::check($request->password, $donatur->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed!',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Login Berhasil!',
            'data' => $donatur,
            'token' => $donatur->createToken('authToken')->accessToken
        ], 200);
    }
    /**
     * logout
     *
     * @param mixed $request
     * @return void
     */
    public function logout(Request $request)
    {
        $removeToken = $request->user()->tokens()->delete();
        if ($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',
            ]);
        }
    }
}
