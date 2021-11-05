<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword=$request->input('keyword');
        $sort=$request->input('sort');
        $sort_name=$request->input('sort_name');
        $query=new User;
        if($keyword){
            $query=$query->where('user_name','like','%'.$keyword.'%');
        }
        if($sort){
            $query=$query->orderBy('created_at',$sort);
        }
        if($sort_name){
             $query=$query->orderBy('user_name',$sort_name);
        }

       $user=$query->get();
        if ($user->all()) {
                return response()->json([
                    'success' => true,
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'chưa có sp nào trong db'
                ]);
            }

    }
    public function store(UserRequest $request){
         $model = new User();
         $model->fill($request->all());
         $model->save();
         return response()->json([
         'success' => true,
         'data' => $model
         ]);
    }
     public function update(UserRequest $request,$id){
         $user=User::query()->find($id);
         if($user){
             $user->fill($request->all());
             $user->save();
             return response()->json([
                     'success'=>true,
                     'data'=>$user
                 ]);
         }
         return response()->json([
                 'success'=>false,
             ]);
    }
    public function show($id){
         $user = User::query()->find($id);
         if($user){
             return response()->json([
                'success' => true,
                'data' => $user
            ]);
         }return response()->json([
              'success'=>false,
         ]);
    }
     //xoa mem
    public function destroy($id){
        $user=User::find($id);
        $user->delete();
        return response()->json([
                'success' => true,
                'data' => $user
            ]);
    }
    //xoa vv 1
    public function forceDelete($id){
        $user=User::withTrashed()->find($id);
        if($user){
            $user->forceDelete();
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }return response()->json([
              'success'=>false,
         ]);
    }
    //xoa vv all
    public function forceDeleteAll(){
        $user=User::onlyTrashed()->get();
        foreach($user as $user){
            $user->forceDelete();
        }
         return response()->json([
                'success' => true,
                'data' => $user
            ]);
    }
    //list da bi xoa mem
    public function trashed(){
        $user=User::onlyTrashed()->get();
         if($user->all()){
           return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }return response()->json([
             'success' => false,
             'data' => 'no data'

        ]);
    }
    //restore 1
    public function backupOne($id){
         $user=User::onlyTrashed()->find($id);
         if($user){
             $user->restore();
             return response()->json([
                'success' => true,
                'data' => $user
            ]);
         }return response()->json([
              'success'=>false,
         ]);
    }
    //restore all
    public function backupAll(){
         $user=User::onlyTrashed()->get();
        foreach($user as $user){
            $user->forceDelete();
        }
         return response()->json([
                'success' => true,
                'data' => $user
            ]);

    }

}
