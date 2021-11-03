<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterControler extends Controller
{
    public function store(Request $request){

        $validator=Validator::make($request->all(),[
            'user_name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'avatar'=> 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        $model=new User();
        $model->fill($request->all());
        if($request->hasFile('avatar')){
            $newAvatar=uniqid().'-'.$request->avatar->getClientOriginalName();
            $path=$request->avatar->storeAs(date('Y').'/'.date('m').'',$newAvatar);
            $model->avatar=str_replace('public/','',$path);
        }
        $model->save();
        return response()->json([
            'success'=>true,
            'data'=>$model
        ]);
    }
}
