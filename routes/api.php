<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SlideController;
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
    // danh sách tất cả các sp chưa bị xóa mềm
    Route::get('', [ProductController::class, 'index']);
    // thêm mới 1 sp
    Route::post('store', [ProductController::class, 'store']);
    // cập nhật 1 sp
    Route::put('update/{id}', [ProductController::class, 'update']);
    // xóa mềm 1 sp
    Route::delete('delete/{id}', [ProductController::class, 'delete']);
    // xóa vĩnh viễn 1 sp
    Route::delete('force-delete/{id}', [ProductController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
    Route::options('force-delete/all', [ProductController::class, 'forceDeleteAll']);
    // danh sách tất cả các sp đã bị xóa mềm
    Route::get('trashed', [ProductController::class, 'trashed']);
    // backup 1 sp đã bị xóa mềm
    Route::options('backup-one/{id}', [ProductController::class, 'backupOne']);
    // backup tất cả các sp đã bị xóa mềm
    Route::options('backup-all',[ProductController::class,'backupAll']);
     // chi tiết 1 sp
    Route::get('detail/{id}', [ProductController::class, 'show']);

});

Route::prefix('category')->group(function () {

    Route::get('', [CategoryController::class, 'index']);

    Route::post('store', [CategoryController::class, 'store']);

    Route::put('update/{id}', [CategoryController::class, 'update']);
    // xóa mềm 1 dm
    Route::delete('delete/{id}', [CategoryController::class, 'delete']);
    // xóa vĩnh viễn
    Route::delete('force-delete/{id}', [CategoryController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các dm đã bị xóa mềm
    Route::options('force-delete/all', [CategoryController::class, 'forceDeleteAll']);
    // danh sách tất cả các dm đã bị xóa mềm
    Route::get('trashed', [CategoryController::class, 'trashed']);
    // backup 1 dm đã bị xóa mềm
    Route::options('backup-one/{id}', [CategoryController::class, 'backupOne']);
    // backup tất cả các dm đã bị xóa mềm
    Route::options('backup-all',[CategoryController::class,'backupAll']);
     // chi tiết 1 dm: ok
    Route::get('detail/{id}', [CategoryController::class, 'show']);
    // lấy tất cả sp trong dm theo id
    // Route::get('product/{id}',[CategoryController::class,'listProduct']);

});
Route::prefix('slide')->group(function () {
    Route::get('', [SlideController::class, 'index']);
    Route::post('store', [SlideController::class, 'store']);
    Route::put('update/{id}', [SlideController::class, 'update']);
    Route::delete('delete/{id}', [SlideController::class, 'destroy']);
});

Route::prefix('blog')->group(function () {
    Route::get('', [BlogController::class, 'index']);
    Route::post('store', [BlogController::class, 'store']);
    Route::put('update/{id}', [BlogController::class, 'update']);
    //xoa men
    Route::delete('delete/{id}', [BlogController::class, 'destroy']);
    //list da bi xoa mem
    Route::get('trashed', [BlogController::class, 'trashed']);
    //xoa vv 1
    Route::delete('force-delete/{id}', [BlogController::class, 'forceDelete']);
    //xoa vv all
    Route::delete('force-delete/all', [BlogController::class, 'forceDeleteAll']);
    //restor 1
    Route::options('backup-one/{id}', [BlogController::class, 'backupOne']);
    //restor all
    Route::options('backup-all',[BlogController::class,'backupAll']);
    Route::get('detail/{id}',[BlogController::class,'show']);
});
Route::prefix('user')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::post('store', [UserController::class, 'store']);
    Route::put('update/{id}', [UserController::class, 'update']);
    //xoa men
    Route::delete('delete/{id}', [UserController::class, 'destroy']);
    //list da bi xoa mem
    Route::get('trashed', [UserController::class, 'trashed']);
    //xoa vv 1
    Route::delete('force-delete/{id}', [UserController::class, 'forceDelete']);
    //xoa vv all
    Route::delete('force-delete/all', [UserController::class, 'forceDeleteAll']);
    //restor 1
    Route::options('backup-one/{id}', [UserController::class, 'backupOne']);
    //restor all
    Route::options('backup-all',[UserController::class,'backupAll']);
    Route::get('detail/{id}',[UserController::class,'show']);
});
Route::prefix('infouser')->group(function () {
    Route::get('',[InfoUserController::class,'index']);
    Route::post('store',[InfoUserController::class,'store']);
    Route::put('update/{id}',[InfoUserController::class,'update']);
    Route::delete('delete/{id}', [InfoUserController::class, 'destroy']);
    //list da bi xoa mem
    Route::get('trashed', [InfoUserController::class, 'trashed']);
    //xoa vv 1
    Route::delete('force-delete/{id}', [InfoUserController::class, 'forceDelete']);
    //xoa vv all
    Route::delete('force-delete/all',[InfoUserController::class,'forceDeleteAll']);
   //restor 1
    Route::options('backup-one/{id}',[InfoUserController::class,'backupOne']);
    //restor all
    Route::options('backup-all',[InfoUserController::class,'backupAll']);
    Route::get('delete/{id}',[InforUserController::class,'show']);
});
// check auth
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::prefix('comment')->group(function () {
    Route::get('', [CommentController::class, 'index']);

    Route::post('store', [CommentController::class, 'store']);

    Route::put('update/{id}', [CommentController::class, 'update']);
   //xoa men
    Route::delete('delete/{id}', [CommentController::class, 'delete']);
   //xoa vv 1
    Route::delete('force-delete/{id}', [CommentController::class, 'forceDelete']);
    //xoa vv all
    Route::options('force-delete/all', [CommentController::class, 'forceDeleteAll']);
    //list da bi xoa mem
    Route::get('trashed', [CommentController::class, 'trashed']);
   //restor 1
    Route::options('backup-one/{id}',[CommentController::class,'backupOne']);
    //restor all
    Route::options('backup-all',[CommentController::class,'backupAll']);

    Route::get('detail/{id}', [CommentController::class, 'show']);


});

Route::middleware('auth:sanctum')->prefix('order')->group(function () {
    // thêm mới một order
    Route::post('add', [OrderController::class, 'add']);
    // list order chưa bị xóa mềm
    Route::get('all', [OrderController::class, 'index']);
    // chi tiết một đơn hàng
    Route::get('{id}', [OrderController::class, 'detail']);
});
