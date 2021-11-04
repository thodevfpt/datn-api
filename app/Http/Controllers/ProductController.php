<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // thêm mới 1 sp
    public function add(ProductFormRequest $request)
    {
        $product = new Product();
        $product->fill($request->all());
        $product->save();
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // cập nhật 1 sp
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->fill($request->all());
            $product->save();
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'sản phẩm không tồn tại'
            ]);
        }
    }

    // xóa mềm 1 sp
    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'sản phẩm không tồn tại'
            ]);
        }
    }

    // xóa vĩnh viễn 1 sp
    public function forceDelete($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product) {
            $product->forceDelete();
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'sản phẩm không tồn tại'
            ]);
        }
    }

    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
    public function forceDeleteAll()
    {

        $products = Product::onlyTrashed()->get();
        foreach ($products as $product) {
            $product->forceDelete();
        }
        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    // danh sách các sp chưa bị xóa mềm
    public function index()
    {
        $products = Product::all();
        // $products->load('category');
        if ($products->all()) {
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Chưa có sản phẩm nào trong dữ liệu'
            ]);
        }
    }

    // danh sách các sp đã bị xóa mềm
    public function deleted()
    {
        $products = Product::onlyTrashed()->get();
        if ($products->all()) {
            return response()->json([
                'success' => true,
                'data' => $products
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Chưa có sản phẩm bị xóa trong dữ liệu'
            ]);
        }
    }

    // chi tiết 1 sp
    public function detail($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product) {
            return response()->json([
                'success' => true,
                'data' => $product
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
        $product = Product::onlyTrashed()->find($id);
        if ($product) {
            $product->restore();
            return response()->json([
                'success' => true,
                'data' => $product
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
        $products = Product::onlyTrashed()->get();
        foreach ($products as $pro) {
            $pro->restore();
        }
        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
