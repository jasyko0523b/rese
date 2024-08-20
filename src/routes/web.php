<?php

//use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\OwnerController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
//use Mockery\VerificationDirector;
//use PHPUnit\Framework\MockObject\Verifiable;

//use GuzzleHttp\Psr7\Request;

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

Route::group(['plefix' => 'email'], function(){
    Route::get('/verify', [VerificationController::class, 'please_verify'])->middleware('auth')->name('verification.notice');

    Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verified'])->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/verification-notification', [VerificationController::class, 'send_request'])->middleware(['auth', 'throttle:6.1'])->name('verification.send');
});


Route::get('/', [CommonController::class, 'index']);
Route::post('/', [CommonController::class, 'search']);
Route::get('/detail/{shop_id}', [CommonController::class, 'detail']);
Route::get('/reservation/{reservation_id}', [CommonController::class, 'reservation_info'])->name('reservation_info');


Route::middleware('verified')->group(function () {
    Route::get('redirects', [AuthController::class, 'index']);
    Route::get('/mypage', [AuthController::class, 'myPage']);
    Route::put('/favorite', [AuthController::class, 'favorite']);
    Route::post('/review', [AuthController::class, 'review']);

    Route::post('/reserve', [AuthController::class, 'reserve']);
    Route::post('/reserve/update', [AuthController::class, 'update']);

    Route::post('/reservation/qr', [AuthController::class, 'qr_index'])->name('qr');
    Route::get('/reservation/qr/download', [AuthController::class, 'download'])->name('qr.download');


    Route::group(['prefix' => 'owner'], function (){
        Route::get('/dashboard', [OwnerController::class, 'index']);
        Route::get('/shop_detail', [OwnerController::class, 'owner_detail']);
        Route::post('/text/update', [OwnerController::class, 'text_update']);
        Route::post('/image/update', [OwnerController::class, 'image_update']);
    });


    Route::group(['prefix' => 'admin'], function (){
        Route::get('/dashboard', [AdminController::class, 'admin']);
        Route::get('/shop_register', [AdminController::class, 'register']);
        Route::post('/add', [AdminController::class, 'create']);
        Route::get('/email', [AdminController::class, 'email_writing']);
        Route::post('/email/send_all', [AdminController::class, 'send_all']);
    });
});