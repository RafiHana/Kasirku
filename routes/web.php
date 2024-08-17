<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\OrderController;


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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'admin'])->get('/user',
[UserController::class, 'index']);
Route::middleware(['auth', 'admin'])->get('/user/create',
[UserController::class, 'create']);
Route::middleware(['auth', 'admin'])->post('/user/store',
[UserController::class, 'store']);
Route::middleware(['auth', 'admin'])->get('/user/edit/{id}',
[UserController::class, 'edit']);
Route::middleware(['auth', 'admin'])->post('/user/update/{id}',
[UserController::class, 'update']);
Route::middleware(['auth', 'admin'])->post('/user/destroy/{id}',
[UserController::class, 'destroy']);

Route::middleware(['auth', 'admin'])->get('/produk',
[ProdukController::class, 'index']);
Route::middleware(['auth', 'admin'])->get('/produk/create',
[ProdukController::class, 'create']);
Route::middleware(['auth', 'admin'])->post('/produk/store',
[ProdukController::class, 'store']);
Route::middleware(['auth', 'admin'])->get('/produk/edit/{id}',
[ProdukController::class, 'edit']);
Route::middleware(['auth', 'admin'])->post('/produk/update/{id}',
[ProdukController::class, 'update']);
Route::middleware(['auth', 'admin'])->post('/produk/destroy/{id}',
[ProdukController::class, 'destroy']);

Route::middleware(['auth', 'admin'])->get('/order',
[OrderController::class, 'index']);
Route::middleware(['auth', 'admin'])->get('/order/create',
[OrderController::class, 'create']);
Route::middleware(['auth', 'admin'])->post('/order/store',
[OrderController::class, 'store']);
Route::middleware(['auth', 'admin'])->get('/order/edit/{id}',
[OrderController::class, 'edit']);
Route::middleware(['auth', 'admin'])->post('/order/update/{id}',
[OrderController::class, 'update']);
Route::middleware(['auth', 'admin'])->post('/order/destroy/{id}',
[OrderController::class, 'destroy']);
