<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers;


use Intervention\Image\ImageManagerStatic as Im;


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

Auth::routes();

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome.index');
Route::get('/search', [App\Http\Controllers\WelcomeController::class, 'search'])->name('welcome.search');

Route::get('/fetch_hotel_image/{id}', [App\Http\Controllers\HotelController::class, 'fetch_hotel_image']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile/list', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/{id?}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{id?}/edit/name', [\App\Http\Controllers\ProfileController::class, 'edit_name'])->name('profile.edit.name');
Route::get('/profile/{id?}/edit/role', [\App\Http\Controllers\ProfileController::class, 'edit_role'])->name('profile.edit.role');
Route::get('/profile/edit/password', [\App\Http\Controllers\ProfileController::class, 'edit_password'])->name('profile.edit.password');

Route::post('/profile/{id?}/edit/name', [App\Http\Controllers\ProfileController::class, 'update_name'])->name('profile.edit.name');
Route::post('/profile/{id?}/edit/role', [\App\Http\Controllers\ProfileController::class, 'update_role'])->name('profile.edit.role');
Route::post('/profile/edit/password', [App\Http\Controllers\ProfileController::class, 'update_password'])->name('profile.edit.password');

Route::delete('profile/{id}', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');


Route::get('/hotels/list', [App\Http\Controllers\HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/public_show/{id}', [App\Http\Controllers\HotelController::class, 'public_show'])->name('hotels.public_show');

Route::get('/hotels/add', [App\Http\Controllers\HotelController::class, 'add'])->name('hotels.add');
Route::get('/hotels/{user?}', [App\Http\Controllers\HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/owner_show/{hotel}', [App\Http\Controllers\HotelController::class, 'owner_show'])->name('hotels.owner_show');
Route::get('/hotels/edit/{hotel}', [App\Http\Controllers\HotelController::class, 'edit'])->name('hotels.edit');

Route::delete('/hotels/{id}', [App\Http\Controllers\HotelController::class, 'destroy']);

Route::post('/hotels/add', [App\Http\Controllers\HotelController::class, 'store'])->name('hotels.add');
Route::post('/hotels/edit/{hotel?}', [App\Http\Controllers\HotelController::class, 'update'])->name('hotels.update');

Route::get('/orders/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
Route::get('orders/{user?}', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
Route::get('orders/show/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');

Route::post('/profile/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');

Route::post('orders/create', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.create');
Route::post('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
