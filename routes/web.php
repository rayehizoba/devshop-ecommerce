<?php

use App\Http\Livewire\Admin\Pages\CategoryIndex;
use App\Http\Livewire\Admin\Pages\LicenseIndex;
use App\Http\Livewire\Admin\Pages\ProductIndex;
use App\Http\Livewire\User\Pages\CartPage;
use App\Http\Livewire\User\Pages\CategoryPage;
use App\Http\Livewire\User\Pages\Index;
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

Route::get('/', Index::class)->name('home');

Route::get('shop', Index::class)->name('shop.page');

Route::get('category/{slug}', CategoryPage::class)->name('category');

Route::get('product/{slug}', ProductPage::class)->name('product');

Route::get('cart', CartPage::class)->name('cart.page');


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
