<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // register
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),

            [
                'user_name' => 'required|between:3,15',
                'email' => 'required|email|unique:users',
                'password' => 'required|between:5,8',
            ],
            [
                'user_name.required' => 'Trường này không được để trống',
                'user_name.between' => 'Trường này cần tối thiểu 3 ký tự và tối đa 15 ký tự',

                'email.required' => 'Trường này không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email này đã tồn tại',

                'password.required' => 'Trường này không được để trống',
                'password.between' => 'Trường này cần tối thiểu 5 ký tự và tối đa 8 ký tự',

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], 422);
        }
        $user = new User();
        $user->fill($request->all());
        $user->save();
        // cập nhật các voucher cho kh
        $vouchers = Vouchers::all();
        $voucher_id = [];
        foreach ($vouchers as $v) {
            $voucher_id[] = $v->id;
        }
        $user->vouchers()->sync($voucher_id);
        return response()->json([
            'success' => true,
            'data' => 'Đăng ký thành công'
        ]);
    }

    // login
    public function login(Request $request)
    {
        // validate
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|between:5,8',
            ],
            [
                'email.required' => 'Trường này không được để trống',
                'email.email' => 'Email không đúng định dạng',

                'password.required' => 'Trường này không được để trống',
                'password.between' => 'Trường này cần tối thiểu 5 ký tự và tối đa 8 ký tự',

            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $password = $request->password;
        //  check email
        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            $user->load(['info_user', 'roles', 'carts', 'vouchers', 'address_custom']);
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
            'success' => false,
            'data' => 'Đăng nhập thất bại'
        ], 201);
    }

    //  logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'data' => 'Đăng xuất thành công'
        ]);
    }
    // update account
    public function updateAccount(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_name' => 'max:250',
                'avatar' => 'max:250',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], 422);
        }
        $request->user()->update(['user_name' => $request->user_name, 'avatar' => $request->avatar]);
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'password_new' => [
                    'required',
                    'confirmed',
                    Password::min(5)->mixedCase()->numbers(),
                    'max:12'
                ],
                'password_new_confirmation' => [
                    'required',
                    Password::min(5)->mixedCase()->numbers(),
                    'max:12'
                ]
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], 422);
        }
        $email = $request->email;
        $password = $request->password;
        $password_new = $request->password_new;
        $user = $request->user();
        if ($email == $user->email && Hash::check($password, $user->password)) {
            $user->update(['password'=>$password_new]);
            return response()->json([
                'success' => true,
                'data' => 'đổi mk thành công'
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'user không đúng'
        ]);
    }
}
