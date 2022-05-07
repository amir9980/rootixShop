<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;

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

Auth::routes();


Route::get('/',[HomeController::class,'index'])->name('home');

Route::prefix('admin')->middleware(['auth','is_admin'])->group(function (){
   Route::get('/',function (){
       return view('admin/index');
   })->name('admin');

    Route::resource('product',ProductController::class)->except(['show','update','delete']);
    Route::post('product/{product}/update',[ProductController::class,'update'])->name('product.update');
    Route::post('product/{product}/delete',[ProductController::class,'destroy'])->name('product.destroy');


});


Route::get('product/{product}',[ProductController::class,'show'])->name('product.show');

Route::post('cart/{product}',[CartController::class,'store'])->middleware('auth')->name('cart.store');



