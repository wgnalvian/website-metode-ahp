<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Models\SubCategory;
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

Route::controller(CategoryController::class)->prefix('/admin')->middleware('auth.app')->group(function () {
    Route::delete('/category', 'deleteCategory');
    Route::post('/category', 'addCategory');
    Route::get('/category', 'listCategoryView');
    Route::patch('/category', 'editCategory');
    Route::get('/category/add', 'categoryAddView');
    Route::get('/category/edit', 'editCategoryView');
    Route::get('/category/edit', 'editCategoryView');
});

Route::controller(SubCategoryController::class)->prefix('/admin')->middleware('auth.app')->group(function(){
    Route::delete('/subcategory', 'deleteSubCategory');
    Route::post('/subcategory', 'addSubCategory');
    Route::get('/subcategory', 'listSubCategoryView');
    Route::patch('/subcategory', 'editSubCategory');
    Route::get('/subcategory/add', 'addSubCategoryView');
    Route::get('/subcategory/edit', 'editSubCategoryView');
    Route::get('/subcategory/edit', 'editSubCategoryView');
});

Route::controller(AdminController::class)->prefix('/admin')->middleware('auth.app')->group(function(){
    Route::get('/','dashboardView');
});