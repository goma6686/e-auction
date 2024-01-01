<?php

use App\Http\Controllers\AdminController;
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
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use App\Models\Auction;
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
    Route::get('/', [HomeController::class, 'index'])->name('welcome');

    Route::get('/home/{category?}/{type?}', function(?string $category = 'all', ?string $type = 'all'){
    return view('home', [
        'category' => $category,
        'type' => $type
        ]);
    })->name('home');
});

Route::controller(AdminController::class)->group(function() {
    Route::get('/back/{page?}', [AdminController::class, 'index'])->name('back')->middleware('is_admin');
    Route::post('/back/category/store', [AdminController::class, 'store'])->name('admin.store')->middleware('is_admin');
    Route::delete('/back/category/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete')->middleware('is_admin');
});

Route::controller(ProfileController::class)->group(function() {
    Route::get('/profile/{uuid}', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/{uuid}#all', [ProfileController::class, 'profile'])->name('profile.all');
});

Route::controller(ItemController::class)->group(function() {
    Route::post('/store-item', [ItemController::class, 'store'])->name('store-item');
    Route::post('/update-item/{uuid}/{route}', [ItemController::class, 'update'])->name('update-item');
    Route::get('/edit-item/{uuid}/{route}', [ItemController::class, 'edit'])->name('edit-item');
    Route::delete('/delete-item/{uuid}/{route}', [ItemController::class, 'destroy'])->name('delete-item');

    Route::post('/upload-image/{uuid}', [ItemController::class, 'uploadImage'])->name('upload-image');
    Route::delete('/delete-image/{uuid}', [ItemController::class, 'destroyImage'])->name('delete-image');
});

Route::controller(AuctionController::class)->group(function() {
    Route::get('/create-auction/{type}', [AuctionController::class, 'create'])->name('create-auction');
    Route::post('/store-auction/{type}', [AuctionController::class, 'store'])->name('store-auction');
    Route::get('/auction/{uuid}', [AuctionController::class, 'show'])->name('show-auction');
    Route::get('/edit-auction/{uuid}/{route}', [AuctionController::class, 'edit'])->name('edit-auction');
    Route::delete('/delete-auction/{uuid}/{route}', [AuctionController::class, 'destroy'])->name('delete-auction');
    Route::post('/update-auction/{uuid}/{route}', [AuctionController::class, 'update'])->name('update-auction');
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
    Route::post('/bid/{uuid}/{amount}', [TransactionController::class, 'bid'])->name('bid');
    Route::post('/buy/{uuid}', [TransactionController::class, 'buy'])->name('buy');
});

Route::match(['post', 'delete'], '/favourite', [FavouriteController::class, 'toggleAuctionInFavourite'])->name('wishlistToggle');

Route::get('/auction', CreateAuction::class)->name('auction');
Route::get('/choose-item', ChooseItem::class)->name('choose-item');