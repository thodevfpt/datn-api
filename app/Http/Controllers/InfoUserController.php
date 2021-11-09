<?php

namespace App\Http\Controllers;

use App\Http\Requests\infoUserRequest;
use App\Models\InfoUser;
use App\Models\User;
use Illuminate\Http\Request;

class InfoUserController extends Controller
{
    // public function index(Request $request)
    // {
    //     $keyword = $request->input('keyword');
    //     $sort = $request->input('sort');
    //     $gender = $request->input('gender');
    //     $query = InfoUser::all();
    //     if ($keyword) {
    //         $query = $query->where('address', 'like', '%' . $keyword . '%');
    //     }
    //     if ($sort) {
    //         $query = $query->orderBy('created_at', $sort);
    //     }
    //     if ($gender) {
    //         $query = $query->where('gender', '=', $gender);
    //     }
    //     $info = $query;
    //     if ($info->all()) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $info
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'chưa có sp nào trong db'
    //         ]);
    //     }
    // }
    // thêm thông tin chi tiết cho user
    public function store(infoUserRequest $request)
    {
        $model = new InfoUser();
        $model->fill($request->all());
        $model->save();
        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }
    public function update(infoUserRequest $request, $user_id)
    {
        $user = User::find($user_id);
        if ($user) {
            $user->load('info_user');
            $info_user = $user->info_user;
            if ($info_user->all()) {
                $info_user = $info_user->all()[0];
                $info_user->fill($request->all());
                $info_user->save();
                return response()->json([
                    'success' => true,
                    'data' => $info_user
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'data' =>'user chưa có thông tin chi tiết'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'data' =>'user không tồn tại'
            ]);
        }
    }


    // public function show($id)
    // {
    //     $info = InfoUser::query()->find($id);
    //     if ($info) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $info
    //         ]);
    //     }
    //     return response()->json([
    //         'success' => false,
    //     ]);
    // }
    // //xoa mem
    // public function destroy($id)
    // {
    //     $info = InfoUser::find($id);
    //     $info->delete();
    //     return response()->json([
    //         'success' => true,
    //         'data' => $info
    //     ]);
    // }
    // //xoa vv 1
    // public function forceDelete($id)
    // {
    //     $info = InfoUser::withTrashed()->find($id);
    //     if ($info) {
    //         $info->forceDelete();
    //         return response()->json([
    //             'success' => true,
    //             'data' => $info
    //         ]);
    //     }
    //     return response()->json([
    //         'success' => false,
    //     ]);
    // }
    // //xoa vv all
    // public function forceDeleteAll()
    // {
    //     $info = InfoUser::onlyTrashed()->get();
    //     foreach ($info as $info) {
    //         $info->forceDelete();
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'data' => $info
    //     ]);
    // }
    // //list da bi xoa mem
    // public function trashed()
    // {
    //     $info = InfoUser::onlyTrashed()->get();
    //     if ($info->all()) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $info
    //         ]);
    //     }
    //     return response()->json([
    //         'success' => false,
    //         'data' => 'no data'

    //     ]);
    // }
    // //restore 1
    // public function backupOne($id)
    // {
    //     $info = InfoUser::onlyTrashed()->find($id);
    //     if ($info) {
    //         $info->restore();
    //         return response()->json([
    //             'success' => true,
    //             'data' => $info
    //         ]);
    //     }
    //     return response()->json([
    //         'success' => false,
    //     ]);
    // }
    // //restore all
    // public function backupAll()
    // {
    //     $info = InfoUser::onlyTrashed()->get();
    //     foreach ($info as $info) {
    //         $info->forceDelete();
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'data' => $info
    //     ]);
    // }
}
