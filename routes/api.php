<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterControler;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Models\Order;

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

Route::prefix('categories')->group(function () {
    // thêm mới 1 dm: ok
    Route::post('add', [CategoryController::class, 'add']);
    // cập nhật 1 dm: ok
    Route::put('update/{id}', [CategoryController::class, 'update']);
    // xóa mềm 1 dm
    Route::delete('delete/{id}', [CategoryController::class, 'delete']);
    // xóa vĩnh viễn 1 dm: ok
    Route::delete('force-delete/{id}', [CategoryController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các dm đã bị xóa mềm
    Route::options('force-delete/all', [CategoryController::class, 'forceDeleteAll']);
    // danh sách tất cả các dm chưa bị xóa mềm: ok
    Route::get('all', [CategoryController::class, 'index']);
    // danh sách tất cả các dm đã bị xóa mềm
    Route::get('deleted', [CategoryController::class, 'deleted']);
    // chi tiết 1 dm: ok
    Route::get('detail/{id}', [CategoryController::class, 'detail']);
    // backup 1 dm đã bị xóa mềm
    Route::options('backup-one/{id}',[CategoryController::class,'backupOne']);
    // backup tất cả các dm đã bị xóa mềm
    Route::options('backup-all',[CategoryController::class,'backupAll']);
    // lấy tất cả sp trong dm theo id
    // Route::get('product/{id}',[CategoryController::class,'listProduct']);

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







Route::prefix('comments')->group(function () {
    // thêm mới 1 dm
    Route::post('add', [CommentController::class, 'add']);
    // cập nhật 1 dm
    Route::put('update/{id}', [CommentController::class, 'update']);
    // xóa mềm 1 dm
    Route::delete('delete/{id}', [CommentController::class, 'delete']);
    // xóa vĩnh viễn 1 dm
    Route::delete('force-delete/{id}', [CommentController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các dm đã bị xóa mềm
    Route::options('force-delete/all', [CommentController::class, 'forceDeleteAll']);
    // danh sách tất cả các dm chưa bị xóa mềm
    Route::get('all', [CommentController::class, 'index']);
    // danh sách tất cả các dm đã bị xóa mềm
    Route::get('deleted', [CommentController::class, 'deleted']);
    // chi tiết 1 dm
    Route::get('detail/{id}', [CommentController::class, 'detail']);
    // backup 1 dm đã bị xóa mềm
    Route::options('backup-one/{id}',[CommentController::class,'backupOne']);
    // backup tất cả các dm đã bị xóa mềm
    Route::options('backup-all',[CommentController::class,'backupAll']);

});

Route::prefix('order')->group(function(){
    // thêm mới một order
    Route::post('add',[OrderController::class,'add']);
    // list order chưa bị xóa mềm
    Route::get('all',[OrderController::class,'index']);
    // chi tiết một đơn hàng
    Route::get('{id}',[OrderController::class,'detail']);
});

