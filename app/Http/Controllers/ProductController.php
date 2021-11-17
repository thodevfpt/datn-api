<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // danh sách các sp chưa bị xóa mềm
    public function index(Request $request)
    {
        $keyword=$request->input('keyword');
        $sort=$request->input('sort');
        $sort_name=$request->input('sort_name');
        $sort_price=$request->input('sort_price');
        $cate=$request->input('cate');
        $quantity=$request->input('quantity');
        $query= new Product();
        // $products->load('category');
        if($keyword){
            $query=$query->where('name','like','%'.$keyword.'%');
        }
        if($sort){
            $query=$query->orderBy('created_at',$sort);
        }
         if($sort_name){
             $query=$query->orderBy('name',$sort_name);
        }
         if($sort_price){
             $query=$query->orderBy('price',$sort_price);
        }
         if($cate){
             $query=$query->where('cate_id','=',$cate);
        }
          if($quantity){
             $query=$query->where('quantity','=',$quantity);
        }
        $product=$query->get();
        if ($product->all()) {
            return response()->json([
                'success' => true,
                'data' => $product
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Chưa có sản phẩm nào trong dữ liệu'
            ]);
        }
    }

    //list_comments
    public function list_comments($pro_id){
        $product=Product::query()->find($pro_id);
        $product->load('comments');
        return response()->json([
            'success'=>true,
            'data'=> $product->comments,

        ]);

    }

    // thêm mới 1 sp
    public function store(ProductRequest $request)
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
    // chi tiết 1 sp
    public function show($id)
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


    // danh sách các sp đã bị xóa mềm
    public function trashed()
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
