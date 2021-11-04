<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        $data = $request->only([
            'email',
            'password',
        ]);
        $result = Auth::attempt($data);
        if($result==false){
            session()->flash('errors','sai email hoặc password');
            return response()->json([
            'success'=>false,
            ]);
        }
          $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
            'success'=>true,
            'data'=>[
              'user' => $user,
              'token'=>$token]
        ]);

    }
    public function logout(){
        Auth::logout();
        return response()->json([
            'success'=>'đăng xuất thành công',
        ]);
    }
}
