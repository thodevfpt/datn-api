<?php

namespace App\Http\Controllers;

use App\Models\Classify_vouchers;
use Illuminate\Http\Request;

class ClassifyVouchersController extends Controller
{
    public function run()
    {
        $data = [
            'Voucher giảm giá dành cho khách hàng đăng ký mới khách hàng',
            'Voucher giảm giá dành cho khách hàng đã có khách hàng',
            'Voucher miễn phí ship hàng'
        ];
        foreach ($data as $d) {
            $model = new Classify_vouchers();
            $model->name = $d;
            $model->save();
        }
        dd('done');
}
}