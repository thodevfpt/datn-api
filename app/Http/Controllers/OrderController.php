<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
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
        // kiểm tra đơn hàng có sp ko
        if ($request->products) {
            $order = new Order();
            $order->fill($request->all());
            $order->code_orders = time();
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
                'message' => 'Đã xảy ra lỗi khi tạo đơn hàng'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Đơn hàng chưa có sp'
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
    public function shipper_order($shipper_id)
    {
        $model = User::find($shipper_id);
        $listOrder = $model->shipper_orders()->where('shipper_confirm', '=', 0)->get();
        return response()->json([
            'success' => true,
            'data' => $listOrder
        ]);
    }
}
