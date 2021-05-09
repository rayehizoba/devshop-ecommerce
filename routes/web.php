<?php

use App\Http\Livewire\Admin\Category\Add;
use App\Http\Livewire\Admin\Category\Browse;
use App\Http\Livewire\Admin\Pages\CategoryIndex;
use App\Http\Livewire\Admin\Pages\LicenseIndex;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route
    ::middleware(['auth:sanctum', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route
            ::prefix('category')
            ->name('category.')
            ->group(function () {

                Route::get('', CategoryIndex::class)->name('index');

            });

        Route
            ::prefix('license')
            ->name('license.')
            ->group(function () {

                Route::get('', LicenseIndex::class)->name('index');

            });
    });
