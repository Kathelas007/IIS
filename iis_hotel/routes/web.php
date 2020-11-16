<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/profile/{id?}', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/{id?}/edit/name', [\App\Http\Controllers\ProfileController::class, 'edit_name'])->name('profile.edit.name');
Route::get('/profile/{id?}/edit/role', [\App\Http\Controllers\ProfileController::class, 'edit_role'])->name('profile.edit.role');
Route::get('/profile/edit/password', [\App\Http\Controllers\ProfileController::class, 'edit_password'])->name('profile.edit.password');

Route::post('/profile/{id?}/edit/name', [App\Http\Controllers\ProfileController::class, 'update_name'])->name('profile.edit.name');
Route::post('/profile/{id?}/edit/role', [\App\Http\Controllers\ProfileController::class, 'update_role'])->name('profile.edit.role');
Route::post('/profile/edit/password', [App\Http\Controllers\ProfileController::class, 'update_password'])->name('profile.edit.password');

Route::delete('profile/{id}', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('orders/{user?}', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
Route::get('orders/show/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');

Route::post('/profile/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
