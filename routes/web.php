<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Broadcast;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/order-page',[OrderController::class,'order_list'])->name('order.page');
    Route::post('/cart-purchase',[OrderController::class,'create'])->name('cart.purchase');
});

Route::get('/',[ProductController::class,'homeView'])->name('home.page');

Route::get('/detail/{id}',[ProductController::class,'detail'])->name('product.detail');

Route::prefix('super_admin')->middleware(['auth','role:super_admin'])->group(function(){
    Route::get('/user-manager',[UserController::class,'show'])->name('user.manager');
    Route::get('add-page',function(){
        return view('super_admin.add');
    })->name('user.add.page');
    Route::post('add-user',[UserController::class,'create'])->name('add.user');
    Route::get('update-page/{id}',[UserController::class,'detail']);
    Route::get('delete/{id}',[UserController::class,'delete']);
    Route::post('/update-user/{id}',[UserController::class,'update'])->name('update.user');
});

// Chỉ có admin và super_admin có quyền
Route::prefix('admin')->middleware(['auth','role:admin,super_admin'])->group(function(){
    Route::get('/product-manager',[ProductController::class,'show'])->name('product.manager');
    Route::get('/add-product-page',function(){
        return view('admin.addProduct');
    })->name('product.add.page');
    Route::post('/add-product',[ProductController::class,'create'])->name('add.product');
    Route::get('/update-page/{id}',[ProductController::class,'updatePage'])->name("update.page");
    Route::get('/delete/{id}',[ProductController::class,'delete']);
    Route::post('update-product/{id}',[ProductController::class,'update'])->name('update.product');
    Route::get('/order',[OrderController::class,'order_by_status']);
    Route::get('/update-status-page/{id}',[OrderController::class,'updateStatusPage'])->name('update.status.page');
    Route::post('/update-status/{id}',[OrderController::class,'updateStatus'])->name('update.status');
});

Route::get('/follow-order/{id}',[OrderController::class,'follow'])->name('order.follow');

Route::get('/cart',[CartController::class,'index'])->name('cart.index');

Route::post('/add-to-cart/{id}',[CartController::class,'add'])->name('cart.add');

Route::post('/delete-item/{id}',[CartController::class,'delete'])->name('cart.delete');

Route::get('/product-search',[ProductController::class,'search'])->name('product.search');

Route::get('/product-sort',[ProductController::class,'sort'])->name('product.sort');    

require __DIR__.'/auth.php';
