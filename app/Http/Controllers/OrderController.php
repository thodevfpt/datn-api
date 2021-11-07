<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // list order chưa bị xóa mềm
    public function index(Request $request)
    {
        $orders = Order::all();
        if ($orders->all()) {
            $orders->load('order_details');
            return response()->json([
                'success' => true,
                'data' => $orders
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Chưa có đơn hàng nào '
            ]);
        }
    }

    // thêm mới order
    public function add(Request $request)
    {

        $order = new Order();
        $order->fill($request->all());
        $order->save();
        if ($order->id) {
            $arr_pro_details = $request->products;
            foreach ($arr_pro_details as $detail) {
                $detail['order_id'] = $order->id;
                $order_detail = new OrderDetail();
                $order_detail->fill($detail);
                $order_detail->save();
            }
            return response()->json([
                'success' => true,
                'data' => $order
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Tạo đơn hàng không thành công'
        ]);
    }
    // chi tiết một đơn hàng
    public function detail($id)
    {
        $order = Order::find($id);
        if ($order) {
           $order->load('order_details');
            return response()->json([
                'success' => true,
                'data' => $order
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'đơn hàng không tồn tại'
        ]);
    }
}
