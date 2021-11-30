<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

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
                'data' => 'Chưa có đơn hàng nào '
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
                'data' => 'Đã xảy ra lỗi khi tạo đơn hàng'
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'Đơn hàng chưa có sp'
        ]);
    }
    // chi tiết một đơn hàng
    public function detail($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->load('order_details', 'customer', 'voucher', 'shipper', 'process');
            return response()->json([
                'success' => true,
                'data' => $order
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'đơn hàng không tồn tại'
        ]);
    }

    // lấy tổng đơn hàng theo các trạng thái
    public function countOrderProcess()
    {
        $order = DB::table('orders')
            ->select(DB::raw('COUNT(process_id) as count, process_id'))
            ->groupBy('process_id');
        $data = DB::table('order_processes')
            ->select('count', 'name', 'process_id')
            ->joinSub($order, 'op', function ($join) {
                $join->on('order_processes.id', '=', 'op.process_id');
            })->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
    // lấy đơn hàng theo trạng thái xử lí
    public function get_order_process($process_id)
    {
        $model = Order::where('process_id', $process_id)->get();
        if ($model->all()) {
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'no data'
        ]);
    }

    // update đơn hàng => chưa xử lí theo id
    public function updateNoProcessId($order_id)
    {
        // chưa validate
        $model = Order::find($order_id);
        if ($model) {
            $model->update(['process_id' => 1]);
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => 'đơn hàng không tồn tại'
        ]);
    }

    // update đơn hàng => chưa xử lí theo mảng id
    public function updateNoProcessArrayId(Request $request)
    {
        //    chưa validate
        if (is_array($request->order_id) && $request->order_id) {
            foreach ($request->order_id as $id) {
                $model = Order::find($id);
                $model->update(['process_id' => 1]);
            }
            return response()->json([
                'success' => true,
                'data' => 'update thành công'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'bạn chưa chọn đơn hàng'
        ]);
    }

    // update đơn hàng => đang xử lí theo id
    public function updateProcessingId(Request $request,$order_id)
    {
        // chưa validate
        $model = Order::find($order_id);
        if ($model) {
            $model->update(['process_id' => 2,'shop_note' => $request->shop_note]);
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'đơn hàng không tồn tại'
        ]);
    }

    // update đơn hàng => đang xử lí theo mảng id
    public function updateProcessingArrayId(Request $request)
    {
        //    chưa validate
        if (is_array($request->order_id) && $request->order_id) {
            foreach ($request->order_id as $id) {
                $model = Order::find($id);
                $model->update(['process_id' => 2]);
            }
            return response()->json([
                'success' => true,
                'data' => 'update thành công'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'bạn chưa chọn đơn hàng'
        ]);
    }

    // update đơn hàng => chờ giao theo id
    public function updateAwaitDeliveryId(Request $request,$order_id)
    {
        // chưa validate
        $model = Order::find($order_id);
        if ($model) {
            $model->update(['process_id' => 3,'shop_note' => $request->shop_note]);
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'đơn hàng không tồn tại'
        ]);
    }

    // update đơn hàng => chờ giao theo mảng id
    public function updateAwaitDeliveryArrayId(Request $request)
    {
        //    chưa validate
        if (is_array($request->order_id) && $request->order_id) {
            foreach ($request->order_id as $id) {
                $model = Order::find($id);
                $model->update(['process_id' => 3]);
            }
            return response()->json([
                'success' => true,
                'data' => 'update thành công'
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'bạn chưa chọn đơn hàng'
        ]);
    }
    // lấy danh sách shipper
    public function getRoleShipper()
    {
        $roleName=ModelsRole::where('name','shipper')->first();
        if($roleName){
            $users = User::role('shipper')->get();
            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'role không tồn tại trong db'
        ]);
    }
    // update đơn hàng => đang giao theo mảng id
    public function updateDeliveringArrayId(Request $request)
    {
        foreach ($request->order_id as $id) {
            $model = Order::find($id);
            $model->update(['shipper_id' => $request->shipper_id, 'shipper_confirm' => 0]);
        }
        return response()->json([
            'success' => true,
            'data' => 'đã gửi yêu cầu xác nhận đơn hàng thành công'
        ]);
    }

    // hủy bàn giao đơn hàng
    public function cancelDeliveringArrayId(Request $request)
    {
        foreach ($request->order_id as $id) {
            $model = Order::find($id);
            $model->where('shipper_confirm', 0)->update(['shipper_id' => null, 'shipper_confirm' => null]);
        }
        return response()->json([
            'success' => true,
            'data' => 'đã hủy bàn giao đơn hàng thành công'
        ]);
    }

    // cập nhật thêm ghi chú cửa hàng vào đơn hàng
    public function updateShopNote(Request $request, $order_id)
    {
        $model = Order::find($order_id);
        if ($model) {
            $model->update(['shop_note' => $request->shop_note]);
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => 'đơn hàng không tồn tại'
        ]);
    }

    // shop cancel đơn hàng
    public function shopCancelOrder($order_id)
    {
        $model = Order::find($order_id);
        if ($model) {
            $model->delete();
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => 'đơn hàng không tồn tại'
        ]);
    }

    // lọc đơn hàng theo trạng thái xử lí
    public function filterOrderProcess(Request $request, $process_id)
    {
        $model = new Order();
        $model = $model->where('process_id', $process_id);
        // lọc theo hình thức thanh toán
        if ($request->payments != null) {
            $model = $model->where('payments', $request->payments);
        }
        // lọc theo nhân viên
        if ($request->shipper_id != null) {
            $model = $model->where('shipper_id', $request->shipper_id);
        }
        // lọc theo trạng thái đã add nhân viên
        if ($request->shipper_confirm != 2) {
            if ($request->shipper_confirm == null) {
                $model = $model->whereNull('shipper_confirm');
            } elseif ($request->shipper_confirm == 0) {
                $model = $model->where('shipper_confirm', 0);
            }
        }
        // lọc theo số đt
        if ($request->customer_phone != null) {
            $model = $model->where('customer_phone', 'like', '%' . $request->customer_phone . '%');
        }

        // lọc theo mã đơn hàng
        if ($request->code_orders != null) {
            $model = $model->where('code_orders', 'like', $request->code_orders);
        }
        $data = $model->get();
        if ($model) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'không tìm thấy kết quả phù hợp'
        ]);
    }

    // lọc đơn hàng theo trạng thái bàn giao
    public function filterOrderShopConfirm(Request $request, $shop_confirm)
    {
        $model = new Order();
        $model = $model->where('shop_confirm', $shop_confirm);
        // lọc theo hình thức thanh toán
        if ($request->payments != null) {
            $model = $model->where('payments', $request->payments);
        }
        // lọc theo nhân viên
        if ($request->shipper_id != null) {
            $model = $model->where('shipper_id', $request->shipper_id);
        }
        // lọc theo trạng thái pass/failed
        if ($request->process_id) {
            $model = $model->where('process_id', $request->process_id);
        }
        // lọc theo trạng thái yêu cầu bàn giao của nhân viên
        if ($request->shipper_confirm != 2) {
            if ($request->shipper_confirm == null) {
                $model = $model->whereNull('shipper_confirm');
            } elseif ($request->shipper_confirm == 0) {
                $model = $model->where('shipper_confirm', 0);
            }
        }
        // lọc theo mã đơn hàng
        if ($request->code_orders != null) {
            $model = $model->where('code_orders', 'like', $request->customer_phone);
        }
        $data = $model->get();
        if ($model) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
        return response()->json([
            'success' => false,
            'data' => 'không tìm thấy kết quả phù hợp'
        ]);
    }

    // tìm kiếm đơn hàng theo phone or code
    public function searchPhoneOrCode(Request $request)
    {
        $order=new Order();
        if($request->phone){
            $order=$order->where('customer_phone','like','%'.$request->phone.'%');
        }
        if($request->code){
            $order=$order->where('code_orders','LIKE',$request->code);
        }
        $order=$order->get();
        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }
    // list đơn hàng theo trạng thái bàn giao
    public function get_order_shop_confirm($shop_confirm_id)
    {
        if ($shop_confirm_id == 1) {
            $model = Order::where('shop_confirm', $shop_confirm_id)->get();
            if ($model->all()) {
                return response()->json([
                    'success' => true,
                    'data' => $model
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => 'no data'
                ]);
            }
        } elseif ($shop_confirm_id == 0) {
            $model = Order::whereNull()->orWhere('shop_confirm', $shop_confirm_id)->get();
            if ($model->all()) {
                return response()->json([
                    'success' => true,
                    'data' => $model
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => 'no data'
                ]);
            }
        }
    }

    // xác nhận bàn giao từ nhân viên
    public function update_shop_confirm(Request $request)
    {
        foreach ($request->order_id as $id) {
            Order::find($id)->update(['shop_confirm' => 1, 'time_shop_confirm' => Carbon::now()->toDateTimeString()]);
        }
        return response()->json([
            'success' => true,
            'data' => 'xác nhận bàn giao thành công'
        ]);
    }

    // xóa mềm đơn hàng
    public function deleteOrder(Request $request)
    {
        foreach ($request->order_id as $id) {
            Order::where('id', $id)->delete();
        }
        return response()->json([
            'success' => true,
            'data' => 'xóa thành công'
        ]);
    }

    // cập nhật trạng thái cho các đơn hàng tiếp tục xử lí
    public function updateNewProcess(Request $request)
    {
        foreach ($request->order_id as $id) {
            Order::find($id)->update(['shipper_id' => null, 'shipper_confirm' => null, 'shop_confirm' => null,'time_shop_confirm'=>null, 'process_id' => $request->process]);
        }
        return response()->json([
            'success' => true,
            'data' => 'cập nhật trạng thái cho mới cho các đơn hàng thành công'
        ]);
    }


    ################### API dành cho nhân viên ###############################

    // lấy đơn hàng của shipper theo trạng thái
    public function shipper_order($shipper_id, $process_id)
    {
        $model = Order::where('shipper_id', $shipper_id)->where('process_id', $process_id)->get();
        if ($model->all()) {
            return response()->json([
                'success' => true,
                'data' => $model
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => 'no data'
        ]);
    }

    // xác nhận đã nhận đơn hàng theo mảng order_id
    public function updateShipperConfirm(Request $request)
    {
        foreach ($request->order_id as $id) {
            Order::find($id)->update(['shipper_confirm' => 1,'process_id' => 4]);
        }
        return response()->json([
            'success' => true,
            'data' => 'xác nhận thành công'
        ]);
    }

    // cập nhật trạng thái thành công cho đơn hàng theo id
    public function updateSuccessOrder($order_id)
    {
        $model = Order::find($order_id)->update(['process_id' => 5]);
        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }
    // cập nhật trạng thái hủy cho đơn hàng theo id
    public function updateCancelOrder(Request $request, $order_id)
    {
        $model = Order::find($order_id)->update(['process_id' => 6, 'cancel_note' => $request->cancel_note]);
        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }
    // gửi yêu cầu bàn giao đơn hàng theo mảng order_id
    public function shipperUpdateShopConfirm(Request $request)
    {
        foreach ($request->order_id as $id) {
            Order::find($id)->update(['shop_confirm' => 0]);
        }
        return response()->json([
            'success' => true,
            'data' => 'gửi yêu cầu xác nhận đơn hàng thành công'
        ]);
    }
    // lấy thông tin chi tiết đơn hàng
   
}
