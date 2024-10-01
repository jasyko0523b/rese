<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RedirectController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QrController;


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

Route::get('/', [SearchController::class, 'index']);
Route::post('/', [SearchController::class, 'index']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);
Route::get('/reservation/{reservation_id}', [QrController::class, 'reservation_info'])->name('reservation_info');


Route::middleware('verified')->group(function () {
    Route::get('redirects', [RedirectController::class, 'index']);
    Route::put('/favorite', [FavoriteController::class, 'favorite']);
    Route::post('/review', [ReviewController::class, 'review']);

    Route::get('/mypage', [ReservationController::class, 'my_page']);

    Route::post('/reservation/create', [ReservationController::class, 'create']);
    Route::post('/reservation/update', [ReservationController::class, 'update']);
    Route::post('/reservation/delete', [ReservationController::class, 'delete']);
    Route::post('/reservation/qr', [QrController::class, 'qr_index'])->name('qr');
    Route::get('/reservation/qr/download', [QrController::class, 'download'])->name('qr.download');


    Route::group(['prefix' => 'owner'], function (){
        Route::get('/dashboard', [ReservationController::class, 'index']);
        Route::get('/shop_detail', [ShopController::class, 'owner_detail']);
        Route::post('/shop_detail/update/text', [ShopController::class, 'update_text']);
        Route::post('/shop_detail/update/image', [ShopController::class, 'update_image']);
    });

    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/amount', [PaymentController::class, 'amount'])->name('amount');
        Route::post('/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
    });

    Route::group(['prefix' => 'admin'], function (){
        Route::get('/dashboard', [SearchController::class, 'admin']);
        Route::get('/shop_register', [ShopController::class, 'register']);
        Route::post('/add', [ShopController::class, 'create']);
        Route::get('/email', [MailController::class, 'email_writing']);
        Route::post('/email/send_all', [MailController::class, 'send_all']);
    });
});