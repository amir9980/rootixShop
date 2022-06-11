<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\WalletPaymentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PaymentReportController;
use App\Http\Controllers\DiscountTokenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\App;

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


App::setLocale('fa');

Auth::routes();

Route::prefix('file')->group(function (){
    Route::get('/image/{fileName}', [FileController::class,'product'])->name('images.product');
    Route::get('/profile/{fileName}', [FileController::class,'user'])->name('images.user');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/', function () {
        return view('admin/index');
    })->name('admin');

    Route::resource('product', ProductController::class)->except(['show', 'update', 'delete']);
    Route::resource('users', UserController::class);

    Route::post('product/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('product/{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('product/{product}/status', [ProductController::class, 'status'])->name('product.status');

    Route::resource('discountToken',DiscountTokenController::class);


});


Route::get('product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::prefix('cart')->middleware('auth')->group(function (){
    Route::post('{product}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('{product}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/', [CartController::class, 'show'])->name('cart.show');
});


Route::prefix('factor')->middleware('auth')->group(function (){
    Route::post('store', [FactorController::class, 'store'])->name('factor.store');
    Route::get('index', [FactorController::class, 'index'])->name('factor.index');
    Route::get('{factor}/show', [FactorController::class, 'show'])->name('factor.show');
    Route::post('confirmDetails/', [FactorController::class, 'confirmDetails'])->name('factor.confirm.details');
    Route::get('orderDetails/', [FactorController::class, 'orderDetails'])->name('factor.order');
});

Route::prefix('profile')->middleware('auth')->group(function (){
    Route::get('/',[ProfileController::class,'show'])->name('profile.show');
    Route::put('/update',[ProfileController::class,'update'])->name('profile.update');
});

Route::prefix('user')->group(function (){
    Route::get('charge',[UserController::class,'charge'])->name('users.charge')->middleware('auth');
});


Route::post('payment/{user}/store',[WalletPaymentController::class,'store'])->name('payment.store')->middleware('auth');

