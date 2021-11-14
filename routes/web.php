<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
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


Route::get('/', [MainController::class, 'index'])->name('main');
Route::get('/about', [MainController::class, 'about'])->name('about');
Route::get('/profile', [MainController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/menu', [ItemController::class, 'showAll'])->name('items');

Route::get('/orders', [OrderController::class, 'showAll'])->name('orders')->middleware('user')->middleware('auth');

Route::get('/cart', [CartController::class, 'showAll'])->name('cart')->middleware('user')->middleware('auth');
Route::post('/cart/add/{itemId}', [CartController::class, 'add'])->name('add.cart')->middleware('user')->middleware('auth');
Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('remove.cart')->middleware('user')->middleware('auth');
Route::post('/cart/send', [CartController::class, 'send'])->name('send.cart')->middleware('user')->middleware('auth');

Route::get('/admin/category', [CategoryController::class, 'showAll'])->name('categories')->middleware('auth')->middleware('admin');
Route::get('/admin/category/new', [CategoryController::class, 'new'])->name('new.category')->middleware('auth')->middleware('admin');
Route::post('/admin/category/store', [CategoryController::class, 'add'])->name('store.category')->middleware('auth')->middleware('admin');
Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('edit.category')->middleware('auth')->middleware('admin');
Route::post('/admin/category/{id}/update', [CategoryController::class, 'modify'])->name('modify.category')->middleware('auth')->middleware('admin');
Route::post('/admin/category/{id}/delete', [CategoryController::class, 'delete'])->name('delete.category')->middleware('auth')->middleware('admin');

Route::get('/admin/item/new', [ItemController::class, 'new'])->name('new.item')->middleware('auth')->middleware('admin');
Route::post('/admin/item/store', [ItemController::class, 'add'])->name('store.item')->middleware('auth')->middleware('admin');
Route::get('/admin/item/{id}/edit', [ItemController::class, 'edit'])->name('edit.item')->middleware('auth')->middleware('admin');
Route::post('/admin/item/{id}/update', [ItemController::class, 'modify'])->name('modify.item')->middleware('auth')->middleware('admin');
Route::get('/admin/item/{id}/delete', [ItemController::class, 'delete'])->name('delete.item')->middleware('auth')->middleware('admin');
Route::get('/admin/deleteditems', [ItemController::class, 'showDeleted'])->name('deleted.item')->middleware('auth')->middleware('admin');
Route::post('/admin/item/{id}/restore', [ItemController::class, 'restore'])->name('restore.item')->middleware('auth')->middleware('admin');

Route::get('/admin/manage/received', [OrderController::class, 'showReceived'])->name('received.orders')->middleware('auth')->middleware(('admin'));
Route::get('/admin/orders/see/{id}', [OrderController::class, 'seeOrder'])->name('see-order')->middleware('auth')->middleware('admin');

Route::post('/admin/manage/accept/{orderId}', [OrderController::class, 'acceptOrder'])->name('accept-order')->middleware('auth')->middleware('admin');
Route::post('/admin/manage/reject/{orderId}', [OrderController::class, 'rejectOrder'])->name('reject-order')->middleware('auth')->middleware('admin');

Route::get('/admin/manage/processed', [OrderController::class, 'showProcessed'])->name('processed.orders')->middleware('auth')->middleware(('admin'));

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
