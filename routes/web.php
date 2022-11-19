<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/
Route::get('/', function () {
    return Inertia::render('Auth/Login',[
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});
//ログイン後のページ:app/Providers/RouteServiceProvider.phpで定義

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

//以下暫定
Route::get('/home', function (){
    return Inertia::render('App');
})->middleware('auth');//<-ログインユーザーのみのアクセス許可
Route::get('/setting', function () {
    //return view('app');
    return Inertia::render('App');
})->middleware('auth');
Route::get('/lottery', function () {
    //return view('app');
    return Inertia::render('App');
})->middleware('auth');
//最終的にはここまで必ず削除すること