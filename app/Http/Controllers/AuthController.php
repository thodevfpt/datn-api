<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // register
    public function register(Request $request)
    {
        // chưa làm validate
        $user = new User();
        $user->fill($request->all());
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công'
        ]);
    }

    // login
    public function login(Request $request)
    {
        // chưa làm validate
        $email = $request->email;
        $password = $request->password;
        //  check email
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            $token = $user->createToken('auth_login')->plainTextToken;
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Đăng nhập thất bại'
        ],201);
    }

    //  logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Đăng xuất thành công'
        ]);
    }
}
