<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Livewire\ChooseItem;
use App\Livewire\CreateAuction;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(HomeController::class)->group(function() {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/home/{category}', [HomeController::class, 'category'])->name('items.categories');
});

Route::controller(ProfileController::class)->group(function() {
    Route::get('/profile/{uuid}', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/{uuid}#all', [ProfileController::class, 'profile'])->name('profile.all');
});

Route::controller(ItemController::class)->group(function() {
    Route::post('/store-item', [ItemController::class, 'store'])->name('store-item');
    Route::post('/update-item/{uuid}', [ItemController::class, 'update'])->name('update-item');
    Route::get('/edit-item/{uuid}', [ItemController::class, 'edit'])->name('edit-item');
    Route::delete('/delete-item/{uuid}', [ItemController::class, 'destroy']);

    Route::post('/upload-image/{uuid}', [ItemController::class, 'uploadImage'])->name('upload-image');
    Route::delete('/delete-image/{uuid}', [ItemController::class, 'destroyImage'])->name('delete-image');
});

Route::controller(AuctionController::class)->group(function() {
    Route::get('/create-auction/{type}', [AuctionController::class, 'create'])->name('create-auction');
    Route::post('/store-auction/{type}', [AuctionController::class, 'store'])->name('store-auction');
    Route::get('/auction/{uuid}', [AuctionController::class, 'show'])->name('show-auction');
    Route::get('/edit-auction/{uuid}', [AuctionController::class, 'edit'])->name('edit-auction');
    Route::delete('/delete-auction/{uuid}', [AuctionController::class, 'destroy']);
    Route::post('/update-auction/{uuid}', [AuctionController::class, 'update'])->name('update-auction');
});

Route::controller(RegisterController::class)->group(function() {
    Route::post('/store', 'store')->name('store');
    Route::get('/register', 'create')->name('register');
});

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(TransactionController::class)->group(function() {
    Route::post('/bid/{uuid}', [TransactionController::class, 'bid'])->name('bid');
    Route::post('/buy/{uuid}', [TransactionController::class, 'buy'])->name('buy');
});

Route::match(['post', 'delete'], '/favourite', [FavouriteController::class, 'toggleAuctionInFavourite'])->name('wishlistToggle');

Route::get('/auction', CreateAuction::class)->name('auction');
Route::get('/choose-item', ChooseItem::class)->name('choose-item');