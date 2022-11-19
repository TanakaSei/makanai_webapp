<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\menuController;
use App\Http\Controllers\api\v1\SettingController;
use Illuminate\Http\Request;
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
Route::get('menus', [menuController::class, 'index']);
Route::get('lottery', [menuController::class, 'lottery']);
Route::post('setting/save', [SettingController::class, 'store']);
Route::get('setting/list', [SettingController::class, 'list']);
Route::get('setting/ctegory-value', [SettingController::class, 'category_value']);
Route::get('setting', [settingController::class, 'index']);