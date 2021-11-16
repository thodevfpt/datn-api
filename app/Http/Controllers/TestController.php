<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TestController extends Controller
{
    public function testTime()
    {
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
