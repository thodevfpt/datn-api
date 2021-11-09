<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    // list user chưa bị xóa mềm có bao gồm lọc
    public function index(Request $request)
    {
        $name = $request->name;
        $role = $request->role;
        $email = $request->email;
        $sort = $request->sort;
        $query = new User;
        if ($name) {
            $query = $query->where('user_name', 'like', '%' . $name . '%');
        }
        if ($role > 0) {
            $query = $query->where('role', $role);
        }
        if ($email) {
            $query = $query->where('user_name', 'like', '%' . $email . '%');
        }
        if ($sort == 1) {
            // tăng dần theo anpha
            $query = $query->orderBy('user_name');
        } elseif ($sort == 2) {
            // giảm dần theo anpha
            $query = $query->orderByDesc('user_name');
        } elseif ($sort == 3) {
            // cập nhật mới nhất
            $query = $query->orderByDesc('created_at');
        } elseif ($sort == 4) {
            // cập nhật cũ nhất
            $query = $query->orderBy('created_at');
        }

        $user = $query->get();
        if ($user->all()) {
            $user->load('info_user');
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => 'không có sp phù hợp trong db'
            ]);
        }
    }
   
    //xoa mem 1 user
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'User không tồn tại'
        ]);
    }
    //xoa vĩnh viễn 1 user
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        if ($user) {
            $user->forceDelete();
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'user không tồn tại'
        ]);
    }

    //list user đã xóa mềm
    public function trashed()
    {
        $user = User::onlyTrashed()->get();
        if ($user->all()) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'user không tồn tại'

        ]);
    }

    //restore 1 user
    public function backupOne($id)
    {
        $user = User::onlyTrashed()->find($id);
        if ($user) {
            $user->restore();
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'user không tồn tại'
        ]);
    }

    //restore all
    public function backupAll()
    {
        $user = User::onlyTrashed()->get();
        foreach ($user as $u) {
            $u->restore();
        }
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
