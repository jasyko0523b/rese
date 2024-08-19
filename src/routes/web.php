<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\QrController;
use App\Models\Reservation;
use PHPUnit\Framework\MockObject\Verifiable;

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

/* メールをかくにんしてくださいのビュー */
Route::get('/email/verify', function(){
    if(!is_null(Auth::user()->email_verified_at)){
        return redirect('redirects');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

/* メールに貼られたリンクを押すと呼ばれるルート */
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request){
    $request->fulfill();
    return redirect('/mypage');
})->middleware(['auth','signed'])->name('verification.verify');

/* メールの再送信をリクエスト */
Route::post('/email/verification-notification', function(Request $request){
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', __('message.retransmission'));
})->middleware(['auth', 'throttle:6.1'])->name('verification.send');

Route::get('/', [ShopController::class, 'index']);
Route::post('/', [ShopController::class, 'search']);
Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);
Route::get('/reservation/{reservation_id}', [ReservationController::class, 'info'])->name('reservation_info');

Route::middleware('verified')->group(function () {
    Route::get('redirects', [AuthController::class, 'index']);
    Route::get('/mypage', [AuthController::class, 'myPage']);
    Route::put('/favorite', [AuthController::class, 'favorite']);
    Route::post('/review', [AuthController::class, 'review']);

    Route::post('/reserve', [ReservationController::class, 'reserve']);
    Route::post('/reserve/update', [ReservationController::class, 'update']);

    Route::post('/reservation/qr', [QrController::class, 'index'])->name('qr');
    Route::get('/qr/download', [QrController::class, 'download'])->name('qr.download');


    Route::get('/owner/dashboard', [ReservationController::class, 'index']);
    Route::get('/owner/shop_detail', [ShopController::class, 'owner_detail']);
    Route::post('/owner/text/update', [ShopController::class, 'text_update']);
    Route::post('/owner/image/update', [ShopController::class, 'image_update']);


    Route::get('/admin/dashboard', [AdminController::class, 'admin']);
    Route::get('/admin/shop_register', [AdminController::class, 'register']);
    Route::post('/admin/add', [AdminController::class, 'create']);
    Route::get('/admin/email', [AdminController::class, 'email_writing']);
    Route::post('/admin/email/send_all', [AdminController::class, 'send_all']);

});