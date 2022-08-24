<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlternativeDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Models\AlternativeData;
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
    Route::get('/profile', 'profileV');
    Route::patch('/profile','profileEdit');
    Route::get('/profile/edit','profileEditV');
    Route::get('/change-password','changePasswordV');
    Route::patch('/change-password','changePassword');
});

Route::controller(CategoryController::class)->prefix('/admin')->middleware('auth.app')->group(function () {
    Route::delete('/category', 'deleteCategory');
    Route::post('/category', 'addCategory');
    Route::get('/category', 'listCategoryView');
    Route::patch('/category', 'editCategory');
    Route::get('/category/add', 'categoryAddView');
    Route::get('/category/edit', 'editCategoryView');
    Route::get('/category/edit', 'editCategoryView');
    Route::get('/category/compar', 'comparCateogryView');
    Route::patch('/category/compar', 'editCategoryCompar');
    Route::post('/category/compar', 'doComparCategory');
    Route::get('/category/compar/list', 'categoryComparView');
    Route::get('/category/compar/edit', 'categoryComparEditView');
});

Route::controller(SubCategoryController::class)->prefix('/admin')->middleware('auth.app')->group(function () {
    Route::delete('/subcategory', 'deleteSubCategory');
    Route::post('/subcategory', 'addSubCategory');
    Route::get('/subcategory', 'listSubCategoryView');
    Route::patch('/subcategory', 'editSubCategory');
    Route::get('/subcategory/add', 'addSubCategoryView');
    Route::get('/subcategory/edit', 'editSubCategoryView');
    Route::get('/subcategory/edit', 'editSubCategoryView');
    Route::post('/subcategory/compar', 'subcategoryCompar');
    Route::patch('/subcategory/compar', 'editSubCategoryCompar');
    Route::get('/subcategory/compar/1', 'comparSubcategoryView1');
    Route::get('/subcategory/compar/2', 'comparSubcategoryView2');
    Route::get('/subcategory/compar/edit', 'subcategoryComparEditV');
    Route::get('/subcategory/compar/list/1', 'listSubCategoryC1');
    Route::get('/subcategory/compar/list/2', 'listSubCategoryC2');
});

Route::controller(AlternativeDataController::class)->middleware('auth.app')->group(function () {
    Route::post('/mahasiswa', 'addMahasiswa');
    Route::delete('/mahasiswa','deleteMahasiswa');
    Route::patch('/mahasiswa', 'editMahasiswa');
    Route::get('/mahasiswa', 'listMahasiswaV');
    Route::get('/mahasiswa/add', 'addMahasiswaV');
    Route::get('/mahasiswa/edit', 'editMahasiswaV');
    Route::post('/mahasiswa/choose','doChoose');
    Route::get('/mahasiswa/choose/{id}','doChooseV');
    Route::get('/mahasiswa-ranking','rankingMahasiswaV');
    Route::get('/alternative-data','alternativeDataV');
    Route::delete('/alternative-data','deleteChoose');
});



Route::controller(AdminController::class)->prefix('/admin')->middleware('auth.app')->group(function () {
    Route::get('/', 'dashboardView');
});

Route::fallback(function () {
    return view('error.no_page');
});
