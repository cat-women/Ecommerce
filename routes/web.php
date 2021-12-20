<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
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
/*
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth'])->name('dashboard');
*/

//main route 
Route::get('/', [ProductsController::class, 'main'])->name('mainPage');

//Products route
Route::get('/searchProduct', [ProductsController::class, 'searchProduct'])->name('searchProduct');
Route::resource('products', ProductsController::class);

//Carts route
Route::middleware('auth')->group(function(){
Route::get('/carts/remove/{id}', [CartsController::class, 'remove']);
Route::get('/carts/searchCart', [CartsController::class, 'search'])->name('cart.search');
Route::get('/carts/test', [CartsController::class, 'test']);
Route::get('/carts/clear', [CartsController::class, 'clear']);
Route::post('/carts/updateUser/{id}', [CartsController::class, 'updateUser'])->name('updateUser');

Route::resource('carts', CartsController::class);
});


//Order route
Route::middleware('auth')->group(function(){

Route::get('/orders/search', [OrderController::class, 'search'])->name('order.search');
Route::get('/orders/{id}', [OrderController::class, 'orderIndex']);
Route::resource('order', OrderController::class);

});

//Payment Route

Route::middleware('auth')->group(function(){

Route::get('/paypal', [PaymentController::class, 'paypal']);
Route::resource('/payment', PaymentController::class);

});



//Dashbord
Route::prefix('dashboard')->middleware('auth')->group(function () {

Route::get('/', [AdminController::class, 'index'])->name('dashboard');
Route::get('/product', [AdminController::class, 'product'])->name('adminProduct');
Route::get('/order', [AdminController::class, 'order'])->name('adminOrder');
Route::get('/user', [AdminController::class, 'user'])->name('adminUser');
Route::post('chart/productAvail', [AdminController::class, 'productAvail'])->name('chart.productAvail');
Route::get('/chart', [AdminController::class, 'test'])->name('chart.test');

});


//User management
Route::middleware('auth')->group(function(){

Route::post('admin/user/edit/{id}', [AdminController::class, 'editUser'])->name('editUser');
Route::post('admin/user/update/{id}', [AdminController::class, 'updateUser'])->name('updateUser');
Route::delete('admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');

});

require __DIR__.'/auth.php';

//image not upating 