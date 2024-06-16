<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('shop_all');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/thanks', function () {
    return view('thanks');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/mypage', function () {
    return view('my_page');
});
Route::get('/detail', function () {
    return view('shop_detail');
});
Route::get('/done', function () {
    return view('done');
});
