<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function add(CategoryFormRequest $request)
    {
        $categories = new Category();
        $categories->fill($request->all());
        $categories->save();
        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    // cập nhật 1 sp
    public function update(CategoryFormRequest $request, $id)
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

    // xóa mềm 1 sp
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

    // xóa vĩnh viễn 1 sp
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

    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
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

    // danh sách các sp chưa bị xóa mềm
    public function index()
    {

        $categories = Category::all();
        // $categories->load('products');
        $categories = Category::withTrashed()->get();
        if ($categories->all()) {
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'chưa có danh mục nào trong dữ liệu'
            ]);
        }
    }

    // danh sách các sp đã bị xóa mềm
    public function deleted()
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

    // chi tiết 1 sp
    public function detail($id)
    {
        $categories = Category::withTrashed()->find($id);
        if ($categories) {
            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm chưa tồn tại'
            ]);
        }
    }

    // backup 1 sp đã xóa mềm
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
                'message' => 'Sản phẩm chưa tồn tại'
            ]);
        }
    }
    // backup tất cả các sp đã xóa mềm
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
}
