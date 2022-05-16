<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FactorController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

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
Route::get('/image/{fileName}', function ($fileName) {

    $path = storage_path('app/images/products/' . $fileName);


//dd($path);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200, ['Content-Type' => $type]);

    return $response;
})->name('images');

Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', function () {
        return view('admin/index');
    })->name('admin');

    Route::resource('product', ProductController::class)->except(['show', 'update', 'delete']);
    Route::resource('user', UserController::class);

    Route::post('product/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('product/{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('product/{product}/status', [ProductController::class, 'status'])->name('product.status');


});


Route::get('product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::post('cart/{product}', [CartController::class, 'store'])->middleware('auth')->name('cart.store');

Route::post('factor/store', [FactorController::class, 'store'])->middleware('auth')->name('factor.store');
Route::get('factor/index', [FactorController::class, 'index'])->name('factor.index');
Route::get('factor/{factor}/show', [FactorController::class, 'show'])->name('factor.show');





