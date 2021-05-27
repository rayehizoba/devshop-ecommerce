<?php

use App\Http\Controllers\PaymentIntentController;
use App\Http\Livewire\Admin\Pages\CategoryIndex;
use App\Http\Livewire\Admin\Pages\LicenseIndex;
use App\Http\Livewire\Admin\Pages\ProductIndex;
use App\Http\Livewire\User\Pages\CartPage;
use App\Http\Livewire\User\Pages\CategoryPage;
use App\Http\Livewire\User\Pages\CheckoutPage;
use App\Http\Livewire\User\Pages\HomePage;
use App\Http\Livewire\User\Pages\ProductPage;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', HomePage::class)->name('home.page');

Route::get('shop', HomePage::class)->name('shop.page');

Route::get('category/{slug}', CategoryPage::class)->name('category');

Route::get('product/{slug}', ProductPage::class)->name('product');

Route::get('cart', CartPage::class)->name('cart.page');

Route::get('checkout', CheckoutPage::class)->name('checkout.page');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route
    ::middleware(['auth:sanctum', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('category', CategoryIndex::class)->name('category.index');
        Route::get('license', LicenseIndex::class)->name('license.index');
        Route::get('product', ProductIndex::class)->name('product.index');

    });
