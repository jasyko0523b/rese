<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use App\Models\Shop;

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

Route::get('/', [ShopController::class, 'index']);
Route::post('/', [ShopController::class, 'search']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);


Route::middleware('auth')->group(function () {
    Route::get('/mypage', [AuthController::class, 'index']);
    Route::put('/favorite', [AuthController::class, 'favorite']);
    Route::post('/review', [AuthController::class, 'review']);

    Route::post('/reserve', [ReservationController::class, 'reserve']);
    Route::post('/reserve/update', [ReservationController::class, 'update']);


    Route::get('/owner/dashboard', [ReservationController::class, 'index']);

    Route::get('/owner/shop_detail', [ShopController::class, 'owner_detail']);
    Route::post('/owner/update', [ShopController::class, 'update']);
});



Route::get('/admin', function(){
    return view('admin.login');
});
Route::get('/admin/dashboard', [AdminController::class, 'admin']);
Route::get('/admin/shop_register', [AdminController::class, 'register']);
Route::post('/admin/add', [AdminController::class, 'create']);


