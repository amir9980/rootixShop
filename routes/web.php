<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\WalletPaymentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\DiscountTokenController;
use App\Http\Controllers\DiscountEventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
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
//\App\Jobs\CheckDiscountEvents::dispatch();

Auth::routes();

Route::prefix('file')->group(function () {
    Route::get('/image/{fileName}', [FileController::class, 'product'])->name('images.product');
    Route::get('/profile/{fileName}', [FileController::class, 'user'])->name('images.user');
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
//    Route::post('product/deleteImg', [ProductController::class, 'deleteImg'])->name('product.img.delete');

    Route::resource('discountToken', DiscountTokenController::class);
    Route::resource('discountEvent', DiscountEventController::class);

    Route::get('comment/index', [CommentController::class, 'index'])->name('comment.index');
    Route::get('inactiveComments/index', [CommentController::class, 'inactiveCommentsIndex'])->name('inactiveComments.index');
    Route::put('{comment}/activate', [CommentController::class, 'activate'])->name('comment.activate');

    Route::get('factor/index', [FactorController::class, 'adminIndex'])->name('admin.factor.index');
    Route::get('shipping/{shipping}/status', [FactorController::class, 'statusConfirmation'])->name('admin.shipping.statusConfirmation');
    Route::put('shipping/{shipping}/status', [FactorController::class, 'status'])->name('admin.shipping.status');

    Route::resource('category',CategoryController::class)->except(['index','show']);

});

Route::get('category',[CategoryController::class,'index'])->name('category.index');
Route::get('category/{category}',[CategoryController::class,'show'])->name('category.show');


Route::get('product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::post('product/{product}/rate', [ProductController::class, 'rate'])->name('product.rate')->middleware(['auth']);
Route::post('product/{product}/bookmark', [ProductController::class, 'bookmark'])->name('product.bookmark')->middleware(['auth']);

Route::prefix('cart')->middleware(['auth'])->group(function () {
    Route::post('{product}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('{product}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/', [CartController::class, 'show'])->middleware('emptyCart')->name('cart.show');
});

Route::prefix('factor')->middleware(['auth'])->group(function () {
    Route::post('store', [FactorController::class, 'store'])->middleware('emptyCart')->name('factor.store');
    Route::get('index', [FactorController::class, 'index'])->name('factor.index');
    Route::get('{factor}/show', [FactorController::class, 'show'])->name('factor.show');
    Route::post('confirmDetails/', [FactorController::class, 'confirmDetails'])->name('factor.confirm.details');
    Route::get('orderDetails/', [FactorController::class, 'orderDetails'])->middleware('emptyCart')->name('factor.order');
    Route::match(['get', 'post'], 'orderShipping/', [FactorController::class, 'orderShipping'])->name('factor.orderShipping');
    Route::get('orderShipping/search', [FactorController::class, 'searchOrderShipping'])->name('factor.orderShipping.search');
});

Route::prefix('comment')->middleware(['auth'])->group(function () {
    Route::post('store/{product}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('{comment}/delete', [CommentController::class, 'destroy'])->name('comment.destroy');

});


Route::prefix('user')->middleware(['auth'])->group(function () {
    Route::get('profile', [UserController::class, 'showProfile'])->name('profile.show');
    Route::put('profile', [UserController::class, 'storeProfile'])->name('profile.update');
    Route::get('charge', [UserController::class, 'charge'])->name('users.charge');
    Route::get('bookmarks', [UserController::class, 'bookmarks'])->name('users.bookmarks');
});


Route::post('payment/{user}/store', [WalletPaymentController::class, 'store'])->name('payment.store')->middleware(['auth']);


//Route::match(['get', 'post'], '/telegram', function () {
//    $settings = (new \danog\MadelineProto\Settings\Database\Mysql)
//        ->setUri('localhost:3306')
//        ->setPassword('')
//    ->setDatabase('onlineshop')
//    ->setUsername('root')->set(true);
////    $sql = new danog\MadelineProto\Db\MysqlArray();
////    $sql->initStartup();
////
////    $sql->initConnection($settings);
////    var_dump($settings->getTable());
////    echo 'i';
////    die();
//
//
//    echo 'inja';
//    $client = new \danog\MadelineProto\API('session.client1',$settings);
//    $client->start();
//    echo 'inja1';
//
//    $me = $client->getSelf();
//    echo 'inja2';
//
//    echo "Hi".$me['first_name'];
//});
