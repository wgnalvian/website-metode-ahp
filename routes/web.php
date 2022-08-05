<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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



Route::get('/logout', 'App\Http\Controllers\AuthController@doLogout')->middleware('auth.app');

Route::controller(AuthController::class)->middleware('auth.login')->group(function () {
    Route::get('/register', 'registerView');
    Route::post('/register', 'getInputRegister');
    Route::get('/login', 'loginView');
    Route::post('/login', 'getLoginInput');
});


Route::controller(UserController::class)->middleware('auth.app')->group(function () {
    Route::get('/', 'dashboardView');
  
});

