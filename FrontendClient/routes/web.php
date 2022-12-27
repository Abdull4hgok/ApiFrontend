<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\ProductController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

//ProductsControllerRoute
Route::resource('products', ProductController::class)->names([
    'index' => 'products.index',
    'create' => 'products.create',
    'store' => 'products.store',
    // 'show' => 'products.show',
    // 'edit' => 'products.edit',
    // 'update' => 'products.update'
    // 'delete' => 'products.delete'
]);
// Route::get('products.index', [ProductController::class, 'index']); 
// Route::get('products.create', [ProductController::class, 'create']); 
// Route::post('products.store', [ProductController::class, 'store'])->name('login');
Route::get('products.show/{id}', [ProductController::class, 'show'])->name('products.show'); 
 Route::get('products.edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
 Route::post('products.update/{id}', [ProductController::class, 'update'])->name('products.update');
 Route::get('products.destroy/{id}',[ProductController::class,'destroy'])->name('products.destroy');


 
 Route::get('/', [
    'as' => 'redirect-route',
    'uses' => 'PageController@redirectFunction',
]);
//CustomAuthControllerRoute
Route::get('/', [CustomAuthController::class, 'home']); 
Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('postlogin', [CustomAuthController::class, 'login'])->name('postlogin'); 
Route::get('signup', [CustomAuthController::class, 'signup'])->name('register-user');
Route::post('postsignup', [CustomAuthController::class, 'signupsave'])->name('postsignup'); 
Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');
