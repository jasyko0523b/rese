<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;


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

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [AuthController::class, 'index']);
    Route::put('/favorite', [AuthController::class, 'favorite']);
    Route::post('/reserve', [ReservationController::class, 'reserve']);
});

Route::get('/',[ShopController::class, 'index']);
Route::post('/', [ShopController::class, 'search']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

