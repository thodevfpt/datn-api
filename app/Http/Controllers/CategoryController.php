<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $keyword=$request->input('keyword');
        $sort=$request->input('sort');
        $sort_name=$request->input('sort_name');
        $status=$request->input('status');
        $query= new Category;
         if($keyword){
            $query=$query->where('name','like','%'.$keyword.'%');
        }
        if($sort){
            $query=$query->orderBy('created_at',$sort);
        }
         if($sort_name){
             $query=$query->orderBy('name',$sort_name);
        }
          if($status){
             $query=$query->orderBy('status','=',$status);
        }
         $category=$query->get();
        if ($query->all()) {
            $query->load('products');
            return response()->json([
                'success' => true,
                'data' => $category
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'chưa có danh mục nào trong dữ liệu'
            ]);
        }
    }


    public function stored(Request $request)
    {
        $categories = new Category();
        $categories->fill($request->all());
        $categories->save();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $categories = Category::find($id);
        if ($categories) {
            $categories->fill($request->all());
            $categories->save();
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'danh mục không tồn tại'
            ]);
        }
    }

    public function delete($id)
    {
        $categories = Category::find($id);
        if ($categories) {
            $categories->delete();
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'danh mục không tồn tại'
            ]);
        }
    }

    public function show($id)
    {
        $categories = Category::withTrashed()->find($id);
        if ($categories) {
            $categories->load('products');
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục chưa tồn tại'
            ]);
        }
    }



    public function forceDelete($id)
    {
        $categories = Category::withTrashed()->find($id);
        if ($categories) {
            $categories->forceDelete();
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'danh mục không tồn tại'
            ]);
        }
    }


    public function forceDeleteAll()
    {

        $categoriess = Category::onlyTrashed()->get();
        foreach ($categoriess as $categories) {
            $categories->forceDelete();
        }
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }



    public function trashed()
    {
        $categories = Category::onlyTrashed()->get();
        if ($categories->all()) {
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'chưa có danh mục bị xóa trong dữ liệu'
            ]);
        }
    }


    public function backupOne($id)
    {
        $categories = Category::onlyTrashed()->find($id);
        if ($categories) {
            $categories->restore();
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục chưa tồn tại'
            ]);
        }
    }

    public function backupAll()
    {
        $categories = Category::onlyTrashed()->get();
        foreach ($categories as $cate) {
            $cate->restore();
        }
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    // lấy tất cả các sp trong dm theo id
    // public function listProduct($id)
    // {
    //     $categories=Category::find($id);
    //     if ($categories) {
    //         $listProducts=$categories->load('products')->products;
    //         return response()->json([
    //             'success' => true,
    //             'data' => $listProducts
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Danh mục chưa tồn tại'
    //         ]);
    //     }
    // }
}
