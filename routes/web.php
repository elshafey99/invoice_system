<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionsController;
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

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/invoices', [InvoicesController::class, 'index']);

Route::group(['prefix' => 'sections', 'as' => 'sections.'], function () {
    Route::get('/', [SectionsController::class, 'index'])->name('index');
    Route::post('/store', [SectionsController::class, 'store'])->name('store');
    Route::put('/update', [SectionsController::class, 'update'])->name('update');
    Route::delete('/destroy', [SectionsController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
    Route::get('/', [ProductsController::class, 'index'])->name('index');
    Route::post('/store', [ProductsController::class, 'store'])->name('store');
    Route::put('/update', [ProductsController::class, 'update'])->name('update');
    Route::delete('/destroy', [ProductsController::class, 'destroy'])->name('destroy');
});

Route::get('/{page}', [AdminController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
