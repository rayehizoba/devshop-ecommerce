<?php

use App\Http\Controllers\HooksController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Livewire\Admin\Pages\CategoryIndex;
use App\Http\Livewire\Admin\Pages\LicenseIndex;
use App\Http\Livewire\Admin\Pages\OrderIndex;
use App\Http\Livewire\Admin\Pages\ProductIndex;
use App\Http\Livewire\User\Pages\CartPage;
use App\Http\Livewire\User\Pages\CategoryPage;
use App\Http\Livewire\User\Pages\CheckoutPage;
use App\Http\Livewire\User\Pages\HomePage;
use App\Http\Livewire\User\Pages\OrderPage;
use App\Http\Livewire\User\Pages\OrdersPage;
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

Route::post('subscribe', SubscriptionController::class)->name('subscribe');

Route::get('licenses', [LicenseController::class, 'index'])->name('licenses');

Route::post('hooks', HooksController::class);

//Route::get('mailable', function () {
//    $order = App\Models\Order::find(1);
//
//    return new App\Mail\OrderConfirmed($order);
//});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('orders', OrdersPage::class)->name('orders.page');
    Route::get('order/{number}', OrderPage::class)->name('order.page');

});

Route::middleware(['auth:sanctum', 'verified', 'admin'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route
    ::middleware(['auth:sanctum', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('category', CategoryIndex::class)->name('category.index');
        Route::get('license', LicenseIndex::class)->name('license.index');
        Route::get('product', ProductIndex::class)->name('product.index');
        Route::get('order', OrderIndex::class)->name('order.index');

    });
