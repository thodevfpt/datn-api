<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoucherRequest;
use App\Models\Vouchers;
use Illuminate\Http\Request;

class VouchersController extends Controller
{
     public function index(){
        $query= new Vouchers();
        $voucher=$query->get();
        if ($voucher->all()) {
            return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'no data'
            ]);
        }

    }
     public function store(VoucherRequest $request){
         $model = new Vouchers();
         $model->fill($request->all());
         $model->save();
         return response()->json([
         'success' => true,
         'data' => $model
         ]);
    }
     public function update(VoucherRequest $request,$id){
         $voucher=Vouchers::query()->find($id);
         if($voucher){
             $voucher->fill($request->all());
             $voucher->save();
             return response()->json([
                     'success'=>true,
                     'data'=>$voucher
                 ]);
         }
         return response()->json([
                 'success'=>false,
             ]);
    }
     public function show($id){
         $voucher = Vouchers::query()->find($id);
         if($voucher){
             return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
         }return response()->json([
              'success'=>false,
         ]);
    }
    public function destroy($id){
        $voucher=Vouchers::find($id);

        if($voucher){
            $voucher->delete();
            return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
        } return response()->json([
                'success' => false,
                'data' => 'no data'
            ]);

    }
     public function forceDelete($id){
        $voucher=Vouchers::withTrashed()->find($id);
        if($voucher){
            $voucher->forceDelete();
            return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
        }return response()->json([
              'success'=>false,
         ]);
    }
     public function forceDeleteAll(){
        $voucher=Vouchers::onlyTrashed()->get();
        foreach($voucher as $vc){
            $vc->forceDelete();
        }
         return response()->json([
                'success' => true,
                'data' => $vc
            ]);
    }
    public function trashed(){
        $voucher=Vouchers::onlyTrashed()->get();
        if($voucher->all()){
           return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
        }return response()->json([
             'success' => false,
             'data' => 'no data'
        ]);

    }
    public function backupOne($id){
         $voucher=Vouchers::onlyTrashed()->find($id);
         if($voucher){
             $voucher->restore();
             return response()->json([
                'success' => true,
                'data' => $voucher
            ]);
         }return response()->json([
              'success'=>false,
         ]);
    }
     public function backupAll(){
         $voucher=Vouchers::onlyTrashed()->get();
        foreach($voucher as $bl){
            $bl->restore();
        }
         return response()->json([
                'success' => true,
                'data' => $voucher
            ]);

    }
}
