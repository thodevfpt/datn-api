<?php

namespace App\Http\Controllers;

use App\Mail\CreateAccount;
use App\Mail\NotifiOrder;
use App\Mail\VerifyOrder;
use App\Mail\VerifyOrderNew;
use App\Models\Feedbacks;
use App\Models\Order;
use App\Models\User;
use App\Models\Vouchers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function sendMail()
    {
        $data=[
            'notifi'=>'tạo đơn hàng thành công'
        ];
        Mail::to('thonvps09672@fpt.edu.vn')->queue(new NotifiOrder($data));
        dd('done');
        $user=new User();
        $user->password='12345';
        $user->user_name='thọ nguyễn';
        $user->email='thonvps09672@fpt.edu.vn';
        $user->save();
        # 1.5 gửi email thông báo đơn hàng
        $data=[
            'name'=>$user->user_name,
            'password'=>$user->password,
            'url'=>'login.com'
        ];
        Mail::to($user->email)->later(now()->addMinutes(1), new CreateAccount($data));
        dd('done');
        // ////////////////////////
        $to_email='thonvps09672@fpt.edu.vn';
        $data=[
            'code'=>'12345',
            'name'=>'thọ đẹp trai'
        ];
        Mail::to($to_email)->send((new VerifyOrder($data)));
        dd('send mail success');
    }
    public function testTime(Request $request)
    {
        $user=User::find(16);
        $test=$user->update(['user_name'=>'tôi là tôi 1']);
        // $user->delete();
        dd($test);
        $v=Vouchers::find(6);
        $v->users()->sync([1,2]);
        dd('done');
        // $order = Order::where('id',6)->first();
        // dd($order);
    //  $model=Order::find(3);$model->load('feedback');
    $model=Feedbacks::find(1);$model->load('order');
     return response()->json([
        'success'=>true,
        'data' => $model
    ]);
    //  dd($model);

        $order = DB::table('orders')
            ->select(DB::raw('COUNT(process_id) as count, process_id'))
            ->groupBy('process_id');
        $data = DB::table('order_processes')
            ->select('count','name','process_id')
            ->joinSub($order, 'op', function ($join) {
                $join->on('order_processes.id', '=', 'op.process_id');
            })->get();
        return response()->json([
            'success'=>true,
            'data' => $data
        ]);


        dd(1);
        $data = DB::table('orders')
            ->join('order_processes', function ($join) {
                $join->on('orders.process_id', '=', 'order_processes.id')
                    // ->where('order_processes.id', '>', 3);
                    ->groupBy('process_id');
            })->get();
        return response()->json([
            'data' => $data
        ]);
        dd(1);
        $firt = DB::table('orders')->where('id', '>', '5');
        $data = DB::table('orders')
            ->join('order_processes', function ($join) {
                $join->on('orders.process_id', '=', 'order_processes.id')
                    ->where('order_processes.id', '>', 3);
            })
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'orders.user_id')->where('transportation_costs', '>', 2);
            })
            ->select('orders.process_id', 'total_price', 'name', 'user_name', 'users.id')

            ->get();
        return response()->json([
            'data' => $data
        ]);
        dd();
        $year = 2021;
        for ($i = 1; $i <= 12; $i++) {
            $data = Order::select('time_shop_confirm', 'total_price')->whereYear('time_shop_confirm', $year)->whereMonth('time_shop_confirm', $i)->get();
            $total = 0;
            foreach ($data as $value) {
                $total += $value->total_price;
            }
            $dl[$i] = $total;
        }
        return response()->json([
            'data' => $dl
        ]);
        dd();
        $year = 2021;
        $month = 11;
        // tạo đối tượng thời gian do người dùng gửi lên
        $time = Carbon::create($year, $month);
        // lấy số ngày của tháng trong thời gian người dùng gửi lên
        $count = $time->lastOfMonth()->day;
        // lấy các đơn hàng ứng với các ngày trong tháng
        for ($i = 1; $i <= $count; $i++) {
            // tạo đối tượng thời gian ứng với từng ngày trong tháng 
            $time = Carbon::create($year, $month, $i);
            // lấy các đơn hàng 
            $data = Order::select('time_shop_confirm', 'total_price')->whereDate('time_shop_confirm', $time)->get();
            // tính tổng giá trị đơn hàng
            $total = 0;
            foreach ($data as $value) {
                $total += $value->total_price;
            }
            // cập nhật ngày và tổng giá trị đơn hàng tương ứng vào mảng
            $data_order[$i] = $total;
        }
        return response()->json([
            'data' => $data_order
        ]);
        // dd($data_order);
        // lấy thời gian hiện tại
        // $time = Carbon::now(); //trả về 1 obj

        // format đối tượng thời gian
        // $time->format('Y-d-m'); // trả về string

        // tạo một đối tượng thời gian
        // $time=Carbon::create('2020','10','5');
        // $time=Carbon::create('20-01-2021');

        // cộng trừ thêm khoảng thời gian vào obj hiện tại
        // $time->addDays(5); // trả về obj được cộng thêm số ngày được chỉ định
        // $time->subDays(5); // trả về obj được trừ đi số ngày được chỉ định

        // tính chênh lệch giữa 2 khoảng thời gian (ngày)
        // nếu là obj có định dạng ngày-tháng-năm giờ-phút-giây thì mốc thời gian để so sánh là 0 giờ ngày hôm sau -> kết quả sẽ nhỏ hơn một ngày so với phép tính thông thường
        // nếu là obj có định dạng là ngày-tháng-năm thì kết quả là chính xác như phép tính bình thường
        // phép so sánh không phân biệt quá khứ hay tương lai mà chỉ trả về giá trị chênh lệch
        // $time=Carbon::create('16-11-2021');
        // $timeNew=Carbon::create('20-11-2021');
        // $count=$time->diffInDays($timeNew);

        // lấy các thành phần trong thời gian
        // $month =$time->month  ; //chỉ việc gọi đến tên thành phần tương ứng / trả về dạng số

    }
}
