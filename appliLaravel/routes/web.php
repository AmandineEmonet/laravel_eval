<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

Route::get('register', [RegisterController::class, 'create'])->middleware('guest')->name('auth.register.create');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest')->name('auth.register.store');
Route::get('login', [LoginController::class, 'create'])->middleware('guest')->name('auth.login.create');
Route::post('login', [LoginController::class, 'store'])->middleware('guest')->name('auth.login.store');
Route::get('logout', LogoutController::class)->middleware('auth')->name('auth.logout');

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('create', [PostController::class, 'create'])->middleware('auth')->name('posts.create');
Route::post('/', [PostController::class, 'store'])->middleware('auth')->name('posts.store');
Route::get('{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('{post:slug}/edit', [PostController::class, 'edit'])->middleware('auth')->name('posts.edit');
Route::post('{post:slug}', [PostController::class, 'update'])->middleware('auth')->name('posts.update');
Route::get('{post:slug}/delete', [PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');
