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
    return view('app');
});

//リロード後アクセスできない問題解決のための仮処置
Route::get('/', function () {
    return view('app');
});
Route::get('/home', function () {
    return view('app');
});
Route::get('/setting', function () {
    return view('app');
});
Route::get('/lottery', function () {
    return view('app');
});
//最終的にはここまで必ず削除すること