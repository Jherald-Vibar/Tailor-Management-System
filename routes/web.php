<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Tailor\TailorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Auth
Route::get('/', [AuthController::class, 'loginForm'])->name('loginForm');
Route::post('login',[AuthController::class, 'authenticate'])->name('customer-authenticate');
Route::get('register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('register', [AuthController::class, 'userStore'])->name('customer-store');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'noCache'], 'prefix' => 'admin'], function(){
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');

    Route::get('stitch',[AdminController::class, 'indexStitch'])->name('admin-stitch');
    Route::post('stitch-create', [AdminController::class, 'stitchStore'])->name('admin-stitch-store');
    Route::put('stitch-assign/{id}', [AdminController::class, 'stitchAssign'])->name('admin-stitch-assign');

    Route::get('customer-list', [AdminController::class, 'indexCustomer'])->name('admin-customer');
    Route::delete('customer-delete/{id}', [AdminController::class, 'delete'])->name('admin-customer-delete');

    Route::get('tailor-list', [AdminController::class, 'indexTailor'])->name('admin-tailor');
    Route::post('tailor-create', [TailorController::class, 'tailorStore'])->name('admin-tailor-store');
    Route::delete('tailor-delete/{id}', [AdminController::class, 'tailorDelete'])->name('admin-tailor-delete');
    Route::put('tailor-update/{id}', [AdminController::class, 'tailorUpdate'])->name('admin-tailor-update');
});


Route::group(['middleware' => ['auth:customer', 'noCache'], 'prefix' => 'customer'], function(){
    Route::get('dashboard', [CustomerController::class, 'customerDashboard'])->name('customer-dashboard');
    Route::get('order', [CustomerController::class, 'stitchIndex'])->name('customer-stitch');
    Route::post('order', [CustomerController::class, 'stitchStore'])->name('customer-stitch-store');
    Route::delete('order-delete/{id}', [CustomerController::class, 'delete'])->name('customer-order-delete');
    Route::put('stitch-update/{id}', [CustomerController::class, 'stitchUpdate'])->name('customer-stitch-update');
});


Route::group(['middleware' => ['auth:tailor', 'noCache'], 'prefix' => 'tailor'], function(){
    Route::get('dashboard', [TailorController::class, 'tailorDashboard'])->name('tailor-dashboard');
    Route::get('stitch-list',[TailorController::class, 'stitchIndex'])->name('tailor-stitch');
    Route::put('stitch-update/{id}', [TailorController::class, 'stitchUpdate'])->name('stitchUpdate');
});
