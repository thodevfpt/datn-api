<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesApi;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

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
    // thêm mới 1 sp
    Route::post('add', [CategoryController::class, 'add']);
    // cập nhật 1 sp
    Route::put('update/{id}', [CategoryController::class, 'update']);
    // xóa mềm 1 sp
    Route::delete('delete/{id}', [CategoryController::class, 'delete']);
    // xóa vĩnh viễn 1 sp
    Route::delete('force-delete/{id}', [CategoryController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
    Route::options('force-delete/all', [CategoryController::class, 'forceDeleteAll']);
    // danh sách tất cả các sp chưa bị xóa mềm
    Route::get('all', [CategoryController::class, 'index']);
    // danh sách tất cả các sp đã bị xóa mềm
    Route::get('deleted', [CategoryController::class, 'deleted']);
    // chi tiết 1 sp
    Route::get('detail/{id}', [CategoryController::class, 'detail']);
    // backup 1 sp đã bị xóa mềm
    Route::options('backup-one/{id}',[CategoryController::class,'backupOne']);
    // backup tất cả các sp đã bị xóa mềm
    Route::options('backup-all',[CategoryController::class,'backupAll']);

});



Route::prefix('comments')->group(function () {
    // thêm mới 1 sp
    Route::post('add', [CommentController::class, 'add']);
    // cập nhật 1 sp
    Route::put('update/{id}', [CommentController::class, 'update']);
    // xóa mềm 1 sp
    Route::delete('delete/{id}', [CommentController::class, 'delete']);
    // xóa vĩnh viễn 1 sp
    Route::delete('force-delete/{id}', [CommentController::class, 'forceDelete']);
    // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
    Route::options('force-delete/all', [CommentController::class, 'forceDeleteAll']);
    // danh sách tất cả các sp chưa bị xóa mềm
    Route::get('all', [CommentController::class, 'index']);
    // danh sách tất cả các sp đã bị xóa mềm
    Route::get('deleted', [CommentController::class, 'deleted']);
    // chi tiết 1 sp
    Route::get('detail/{id}', [CommentController::class, 'detail']);
    // backup 1 sp đã bị xóa mềm
    Route::options('backup-one/{id}',[CommentController::class,'backupOne']);
    // backup tất cả các sp đã bị xóa mềm
    Route::options('backup-all',[CommentController::class,'backupAll']);

});


