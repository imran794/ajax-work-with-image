<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

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