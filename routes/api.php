<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterControler;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('product')->group(function () {
    // thêm mới 1 sp
    Route::post('add', [ProductController::class, 'add']);
    // cập nhật 1 sp
    Route::put('update/{id}', [ProductController::class, 'update']);
    // xóa mềm 1 sp
    Route::delete('delete/{id}', [ProductController::class, 'delete']);
    // xóa vĩnh viễn 1 sp
    Route::delete('force-delete/{id}', [ProductController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
    Route::options('force-delete/all', [ProductController::class, 'forceDeleteAll']);
    // danh sách tất cả các sp chưa bị xóa mềm
    Route::get('all', [ProductController::class, 'index']);
    // danh sách tất cả các sp đã bị xóa mềm
    Route::get('deleted', [ProductController::class, 'deleted']);
    // chi tiết 1 sp
    Route::get('detail/{id}', [ProductController::class, 'detail']);
    // backup 1 sp đã bị xóa mềm
    Route::options('backup-one/{id}',[ProductController::class,'backupOne']);
    // backup tất cả các sp đã bị xóa mềm
    Route::options('backup-all',[ProductController::class,'backupAll']);

});
Route::prefix('blog')->group(function () {
    Route::get('',[BlogController::class,'index']);
    Route::post('store',[BlogController::class,'store']);
    Route::put('update/{id}',[BlogController::class,'update']);
    //xoa men
    Route::delete('delete/{id}',[BlogController::class,'destroy']);
    //list da bi xoa mem
     Route::get('trashed',[BlogController::class,'trashed']);
    //xoa vv 1
    Route::delete('force-delete/{id}',[BlogController::class,'forceDelete']);
    //xoa vv all
    Route::delete('force-delete/all',[BlogController::class,'forceDeleteAll']);
    //restor 1
    Route::options('backup-one/{id}',[BlogController::class,'backupOne']);
    //restor all
    Route::options('backup-one/all',[BlogController::class,'backupAll']);
    Route::get('detail/{id}',[BlogController::class,'show']);
});
Route::prefix('user')->group(function () {
    Route::get('',[UserController::class,'index']);
    Route::post('store',[UserController::class,'store']);
    Route::put('update/{id}',[UserController::class,'update']);
    //xoa men
    Route::delete('delete/{id}',[UserController::class,'destroy']);
    //list da bi xoa mem
     Route::get('trashed',[UserController::class,'trashed']);
    //xoa vv 1
    Route::delete('force-delete/{id}',[UserController::class,'forceDelete']);
    //xoa vv all
    Route::delete('force-delete/all',[UserController::class,'forceDeleteAll']);
    //restor 1
    Route::options('backup-one/{id}',[UserController::class,'backupOne']);
    //restor all
    Route::options('backup-one/all',[UserController::class,'backupAll']);
    Route::get('{id}',[UserController::class,'show']);
});
Route::prefix('infouser')->group(function () {
    Route::get('',[InfoUserController::class,'index']);
    Route::post('store',[InfoUserController::class,'store']);
    Route::put('update/{infor}',[InfoUserController::class,'update']);
    //xoa men
    Route::delete('delete/{id}',[InfoUserController::class,'destroy']);
    //list da bi xoa mem
    Route::get('trashed',[InfoUserController::class,'trashed']);
    //xoa vv 1
    Route::delete('force-delete/{id}',[InfoUserController::class,'forceDelete']);
    //xoa vv all
    Route::delete('force-delete/all',[InfoUserController::class,'forceDeleteAll']);
    //restor 1
    Route::options('backup-one/{id}',[InfoUserController::class,'backupOne']);
    //restor all
    Route::options('backup-one/all',[InfoUserController::class,'backupAll']);
    Route::get('{infor}',[InforUserController::class,'show']);
});

//// Register Login Logout
Route::post('register',[RegisterControler::class,'store']);
Route::post('login',[LoginController::class,'login']);
Route::get('logout',[LoginController::class,'logout']);
