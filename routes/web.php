<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

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

//Route::group(['prefix' => 'admin'], function () {
//    Voyager::routes();
//});

Auth::routes();

Route::get('/logout', [LoginController::class, 'logout'])->name('get-logout');

Route::middleware(['auth'])->group(function (){
    Route::group([
        'prefix'=>'person',
    ], function (){
        Route::get('/orders', [App\Http\Controllers\Person\OrderController::class, 'index'])->name('person.orders.index');
        Route::get('/orders/{order}', [App\Http\Controllers\Person\OrderController::class, 'show'])->name('person.orders.show');
    });
    Route::group([
        'prefix' => 'admin'
    ], function (){
        Route::group(['middleware' => 'is_admin'], function () {
            Route::get('/orders', [OrderController::class, 'index'])->name('home');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
            Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
            Route::resource('articles', App\Http\Controllers\Admin\ArticleController::class);
        });
    });
});



Route::group(['prefix'=>'basket'] , function () {
    Route::post('/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');
    Route::group(['middleware' => 'basket_not_empty'], function () {
        Route::post('/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');
        Route::post('/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');
        Route::get('/', [BasketController::class, 'basket'])->name('basket');
        Route::get('/place', [BasketController::class, 'basketPlace'])->name('basket-place');
    });
});

Route::get('/optimize', [\App\Http\Controllers\HostingController::class, 'optimize']);


Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/{category_slug}', [MainController::class, 'category'])->name('category');
Route::get('/{category}/{product?}', [MainController::class, 'product'])->name('product'); //Знак вопроса сообщает о необязательности параметра, в атком случае в контроллере нужн указать дефолтное значение




