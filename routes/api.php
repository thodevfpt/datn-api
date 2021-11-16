<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SlideController;

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
// các API của admin
Route::middleware(['auth:sanctum', 'role:Admin|manager order|manager content|manager comment|manager user'])->prefix('admin')->group(function () {
    Route::get('', function () {
        echo 'Bạn được phép truy cập trang admin';
    });
    Route::middleware(['role:Admin|manager content'])->prefix('product')->group(function () {
        // danh sách tất cả các sp chưa bị xóa mềm
        Route::get('', [ProductController::class, 'index']);
        // thêm mới 1 sp
        Route::post('store', [ProductController::class, 'store']);
        // cập nhật 1 sp
        Route::put('update/{id}', [ProductController::class, 'update']);
        // xóa mềm 1 sp
        Route::delete('delete/{id}', [ProductController::class, 'delete']);
        // danh sách tất cả các sp đã bị xóa mềm
        Route::get('trashed', [ProductController::class, 'trashed']);
        // backup 1 sp đã bị xóa mềm
        Route::options('backup-one/{id}', [ProductController::class, 'backupOne']);
        // backup tất cả các sp đã bị xóa mềm
        Route::options('backup-all', [ProductController::class, 'backupAll']);
        Route::middleware(['permission:delete product'])->group(function () {
            // xóa vĩnh viễn 1 sp
            Route::delete('force-delete/{id}', [ProductController::class, 'forceDelete']);
            // xóa vĩnh viễn tất cả các sp đã bị xóa mềm
            Route::options('force-delete/all', [ProductController::class, 'forceDeleteAll']);
        });
    });
    Route::prefix('category')->group(function () {
        // lấy danh sách dm
        Route::get('', [CategoryController::class, 'index']);
        // thêm mới dm
        Route::post('store', [CategoryController::class, 'store']);
        // cập nhật dm
        Route::put('update/{id}', [CategoryController::class, 'update']);
        // xóa mềm 1 dm
        Route::delete('delete/{id}', [CategoryController::class, 'delete']);
        // danh sách tất cả các dm đã bị xóa mềm
        Route::get('trashed', [CategoryController::class, 'trashed']);
        // backup 1 dm đã bị xóa mềm
        Route::options('backup-one/{id}', [CategoryController::class, 'backupOne']);
        // backup tất cả các dm đã bị xóa mềm
        Route::options('backup-all', [CategoryController::class, 'backupAll']);
        // chi tiết 1 dm: ok
        Route::get('detail/{id}', [CategoryController::class, 'show']);
        // list các sp trong dm
        Route::get('product/{cate_id}', [CategoryController::class, 'list_pro']);
        Route::middleware(['permission:delete category'])->group(function () {
            // xóa vĩnh viễn
            Route::delete('force-delete/{id}', [CategoryController::class, 'forceDelete']);
            // xóa vĩnh viễn tất cả các dm đã bị xóa mềm
            Route::options('force-delete/all', [CategoryController::class, 'forceDeleteAll']);
        });
    });

    Route::prefix('slide')->group(function () {
        Route::get('', [SlideController::class, 'index']);
        Route::post('store', [SlideController::class, 'store']);
        Route::put('update/{id}', [SlideController::class, 'update']);
        Route::get('detail/{id}', [SlideController::class, 'show']);
        Route::middleware(['permission:delete slide'])->group(function () {
            Route::delete('delete/{id}', [SlideController::class, 'destroy']);
        });
    });

    Route::prefix('blog')->group(function () {
        Route::get('', [BlogController::class, 'index']);
        Route::post('store', [BlogController::class, 'store']);
        Route::put('update/{id}', [BlogController::class, 'update']);
        //xoa men
        Route::delete('delete/{id}', [BlogController::class, 'destroy']);

        //list da bi xoa mem
        Route::get('trashed', [BlogController::class, 'trashed']);
        //restor 1
        Route::options('backup-one/{id}', [BlogController::class, 'backupOne']);
        //restor all
        Route::options('backup-all', [BlogController::class, 'backupAll']);
        Route::get('detail/{id}', [BlogController::class, 'show']);
        Route::middleware(['permission:delete blog'])->group(function () {
            //xoa vv 1
            Route::delete('force-delete/{id}', [BlogController::class, 'forceDelete']);
            //xoa vv all
            Route::options('force-delete/all', [BlogController::class, 'forceDeleteAll']);
        });
    });

    Route::middleware(['role:Admin|manager user'])->prefix('user')->group(function () {
        // list user chưa bị xóa mềm có bao gồm lọc
        Route::post('all', [UserController::class, 'index']);
        // get user chưa bị xóa mềm 
        Route::delete('delete/{id}', [UserController::class, 'delete']);
        //list user đã xóa mềm
        Route::get('trashed/all', [UserController::class, 'trashed']);
        Route::get('{id}', [UserController::class, 'show']);
        //xoa mềm 1 user
        //restor 1 user
        Route::options('backup-one/{id}', [UserController::class, 'backupOne']);
        //restor all user đã xóa mềm
        Route::options('backup-all', [UserController::class, 'backupAll']);
        // đồng bộ hóa role cho user
        Route::post('syncRoles/{user_id}', [UserController::class, 'syncRoles']);
        Route::middleware(['permission:delete user'])->group(function () {
            //xoa vĩnh viễn 1 user
            Route::delete('force-delete/{id}', [UserController::class, 'forceDelete']);
        });
    });
    Route::middleware(['role:Admin|manager user'])->prefix('info-user')->group(function () {
        // thêm mới info-user
        Route::post('store', [InfoUserController::class, 'store']);
        // update một info_user
        Route::put('update/{user_id}', [InfoUserController::class, 'update']);
    });

    Route::middleware(['role:Admin|manager comment'])->prefix('comment')->group(function () {
        Route::get('', [CommentController::class, 'index']);

        Route::post('store', [CommentController::class, 'store']);

        Route::put('update/{id}', [CommentController::class, 'update']);
        //xoa men
        Route::delete('delete/{id}', [CommentController::class, 'delete']);

        //list da bi xoa mem
        Route::get('trashed', [CommentController::class, 'trashed']);
        //restor 1
        Route::options('backup-one/{id}', [CommentController::class, 'backupOne']);
        //restor all
        Route::options('backup-all', [CommentController::class, 'backupAll']);

        Route::get('detail/{id}', [CommentController::class, 'show']);
        Route::middleware(['permission:delete comment'])->group(function () {
            //xoa vv 1
            Route::delete('force-delete/{id}', [CommentController::class, 'forceDelete']);
            //xoa vv all
            Route::options('force-delete/all', [CommentController::class, 'forceDeleteAll']);
        });
    });

    Route::middleware(['role:Admin|manager order'])->prefix('order')->group(function () {
        // thêm mới một order
        Route::post('add', [OrderController::class, 'add']);
        // list order chưa bị xóa mềm
        Route::get('all', [OrderController::class, 'index']);
        // chi tiết một đơn hàng
        Route::get('{id}', [OrderController::class, 'detail']);
    });
});

// các API của UI User
Route::prefix('product')->group(function () {
    // chi tiết 1 sp
    Route::get('detail/{id}', [ProductController::class, 'show']);
    // danh sách tất cả các sp chưa bị xóa mềm
    Route::get('', [ProductController::class, 'index']);
});

Route::prefix('category')->group(function () {
    // lấy danh sách dm
    Route::get('', [CategoryController::class, 'index']);
    // list các sp trong dm
    Route::get('product/{cate_id}', [CategoryController::class, 'list_pro']);
});

Route::prefix('slide')->group(function () {
    Route::get('', [SlideController::class, 'index']);
    Route::get('detail/{id}', [SlideController::class, 'show']);
});

Route::prefix('blog')->group(function () {
    Route::get('', [BlogController::class, 'index']);
    Route::get('detail/{id}', [BlogController::class, 'show']);
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
});
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('order')->group(function () {
        // thêm mới một order
        Route::post('add', [OrderController::class, 'add']);
        // list order chưa bị xóa mềm
        Route::get('all', [OrderController::class, 'index']);
        // chi tiết một đơn hàng
        Route::get('{id}', [OrderController::class, 'detail']);
    });

    Route::prefix('cart')->group(function () {
        // add cart
        Route::post('add-cart', [CartController::class, 'add']);
    });
});
// setup role và permission mặc định
Route::get('setup_role_permission', [PermissionController::class, 'run']);
