<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('result',function(Request $request){
    dd($request->all());
});
Route::get('Payment', function () {
    $amount = 50000;
    $partnerCode = 'MOMO9NX020211127';
    $accessKey = '5h0W4SQKf3jzZxvR';
    $secretKey = 'bvgxHxx5lfXXoZApDXqkg3gHCOyVtkiP';
    $orderInfo = 'Thanh toán đơn hàng tại MarkVeget';
    $redirectUrl = 'http://localhost:8000/result';
    $ipnUrl = 'http://localhost:8000/result';
    $orderId = time();
    $requestId = time();
    $requestType = "captureWallet";
    $extraData = "";
    $rawSignature = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawSignature, $secretKey);

    $param = [
        'partnerCode' => $partnerCode,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'requestType' => $requestType,
        'extraData' => $extraData,
        'lang' =>  'vi',
        'autoCapture' => false, // không tự động chuyển tiền vào ví đối tác ngay
        'signature' => $signature
    ];

    $response = Http::post('https://test-payment.momo.vn/v2/gateway/api/create', $param);
    //    chuyển hướng đến trang thanh toán của MOMO
    return redirect($response->json()['payUrl']);
});
