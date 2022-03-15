<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('category',[CategoryController::class, 'index'])->name('category.index');
Route::post('add/category',[CategoryController::class, 'AddCategory']);
Route::get('category/fatch',[CategoryController::class, 'CategoryFatch']);
Route::get('edit/fatch/{id}',[CategoryController::class, 'EditFatch']);
Route::post('category/update/{id}',[CategoryController::class, 'CategoryUpdate']);
Route::delete('category/delete/{id}',[CategoryController::class, 'CategoryDelete']);

// brand


Route::get('brand',[BrandController::class, 'Index'])->name('brand.index');
Route::post('add/brand',[BrandController::class, 'BrandStore']);
Route::get('/brand/fetch/data',[BrandController::class, 'BrandFetchData']);
Route::get('/brand/edit/{id}',[BrandController::class, 'BrandEdit']);
Route::post('brand/update/{id}',[BrandController::class, 'BrandUpdate']);
Route::delete('brand/delete/{id}',[BrandController::class, 'BrandDelete']);


// product 

Route::get('product',[ProductController::class, 'Index'])->name('product.index');
Route::post('add/product',[ProductController::class, 'AddProduct']);
Route::get('/product/fatch',[ProductController::class, 'ProductFatch']);