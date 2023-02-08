<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('save-product', [ProductController::class , 'submit'])->name('products.save');
Route::post('update-product', [ProductController::class , 'update'])->name('products.update');
Route::get('load-products', [ProductController::class , 'getProducts'])->name('products.load');
