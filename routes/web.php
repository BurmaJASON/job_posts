<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// category
Route::get('category/data_table', [CategoryController::class, 'ssdataTable'])->name('category.ssdt');
Route::resource('category', CategoryController::class)->except('show');
Route::put('category/restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');


// jobs
Route::get('post/data_query',[PostController::class,'queryTable'])->name('post.queryTable');
Route::resource('post', PostController::class);



