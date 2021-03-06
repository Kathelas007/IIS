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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile/list', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/{id?}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{id?}/edit/firstname', [App\Http\Controllers\ProfileController::class, 'edit_firstname'])->name('profile.edit.firstname');
Route::get('/profile/{id?}/edit/lastname', [App\Http\Controllers\ProfileController::class, 'edit_lastname'])->name('profile.edit.lastname');
Route::get('/profile/{id?}/edit/email', [App\Http\Controllers\ProfileController::class, 'edit_email'])->name('profile.edit.email');
Route::get('/profile/{id?}/edit/role', [\App\Http\Controllers\ProfileController::class, 'edit_role'])->name('profile.edit.role');
Route::get('/profile/edit/password', [\App\Http\Controllers\ProfileController::class, 'edit_password'])->name('profile.edit.password');

Route::post('/profile/{id?}/edit/firstname', [App\Http\Controllers\ProfileController::class, 'update_firstname'])->name('profile.edit.firstname');
Route::post('/profile/{id?}/edit/lastname', [App\Http\Controllers\ProfileController::class, 'update_lastname'])->name('profile.edit.lastname');
Route::post('/profile/{id?}/edit/email', [App\Http\Controllers\ProfileController::class, 'update_email'])->name('profile.edit.email');
Route::post('/profile/{id?}/edit/role', [\App\Http\Controllers\ProfileController::class, 'update_role'])->name('profile.edit.role');
Route::post('/profile/edit/password', [App\Http\Controllers\ProfileController::class, 'update_password'])->name('profile.edit.password');

Route::delete('profile/{id}', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/hotels/list', [App\Http\Controllers\HotelController::class, 'index'])->name('hotels.index')->middleware('auth');
Route::get('/hotels/public_show', [App\Http\Controllers\HotelController::class, 'public_show'])->name('hotels.public_show');
Route::post('/hotels/public_show', [App\Http\Controllers\HotelController::class, 'public_show_post'])->name('hotels.public_show');

Route::get('/hotels/add', [App\Http\Controllers\HotelController::class, 'add'])->name('hotels.add')->middleware('auth');
Route::get('/hotels/{user?}', [App\Http\Controllers\HotelController::class, 'index'])->name('hotels.index')->middleware('auth');
Route::get('/hotels/owner_show/{hotel}', [App\Http\Controllers\HotelController::class, 'owner_show'])->name('hotels.owner_show')->middleware('auth');;
Route::get('/hotels/edit/{hotel}', [App\Http\Controllers\HotelController::class, 'edit'])->name('hotels.edit')->middleware('auth');

Route::delete('/hotels/{id}', [App\Http\Controllers\HotelController::class, 'destroy'])->middleware('auth');

Route::post('/hotels/add', [App\Http\Controllers\HotelController::class, 'store'])->name('hotels.add')->middleware('auth');
Route::post('/hotels/edit/{hotel}', [App\Http\Controllers\HotelController::class, 'update'])->name('hotels.update')->middleware('auth');

Route::get('/hotels/{hotel}/room_type/create', [App\Http\Controllers\RoomTypeController::class, 'create'])->name('roomTypes.create');
Route::get('/hotels/{hotel}/room_type/edit/{roomType}', [App\Http\Controllers\RoomTypeController::class, 'edit'])->name('roomTypes.edit');

Route::post('/hotels/{hotel}/room_type/create', [App\Http\Controllers\RoomTypeController::class, 'store'])->name('roomTypes.create');
Route::post('/hotels/{hotel}/room_type/edit/{roomType}', [App\Http\Controllers\RoomTypeController::class, 'update'])->name('roomTypes.edit');

Route::delete('/room_types/{hotel}/{id}', [App\Http\Controllers\RoomTypeController::class, 'destroy'])->name('roomTypes.destroy')->middleware('auth');

Route::get('/hotels/{hotel}/hotel_clerk/assign', [App\Http\Controllers\HotelController::class, 'clerk_choose'])->name('hotels.clerk_choose')->middleware('auth');
Route::post('/hotels/{hotel}/hotel_clerk/assign', [App\Http\Controllers\HotelController::class, 'clerk_assign'])->name('hotels.clerk_choose')->middleware('auth');
Route::delete('/hotel_clerk/{hotel}/{id}', [App\Http\Controllers\HotelController::class, 'clerk_unassign'])->name('hotels.clerk_unassign')->middleware('auth');

Route::get('hotels/{hotel}/rooms/create', [App\Http\Controllers\RoomController::class, 'create'])->name('rooms.create');
Route::get('hotels/{hotel}/rooms/edit/{room}', [App\Http\Controllers\RoomController::class, 'edit'])->name('rooms.edit');
Route::get('hotels/{hotel}/rooms/{roomType?}', [App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');

Route::post('hotels/{hotel}/rooms/create', [App\Http\Controllers\RoomController::class, 'store'])->name('rooms.create');
Route::post('hotels/{hotel}/rooms/edit/{room}', [App\Http\Controllers\RoomController::class, 'update'])->name('rooms.edit');
Route::delete('/rooms/{hotel}/{id}', [App\Http\Controllers\RoomController::class, 'destroy'])->name('rooms.destroy')->middleware('auth');

Route::get('/orders/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
Route::post('/orders/create', [\App\Http\Controllers\OrderController::class, 'create_post'])->name('orders.create');

Route::get('/orders/summary', [\App\Http\Controllers\OrderController::class, 'summary'])->name('orders.summary');

Route::get('orders/{user?}', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::get('orders/show/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show')->middleware('auth');

Route::post('/profile/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('orders.update')->middleware('auth');

Route::post('orders/store', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
Route::post('orders/filter/{user?}', [\App\Http\Controllers\OrderController::class, 'filter'])->name('orders.filter')->middleware('auth');
Route::post('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('orders.update')->middleware('auth');
