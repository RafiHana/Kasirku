<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

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

