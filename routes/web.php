<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\InvoicesArchivController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentController;

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


Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function () {
    Route::get('/', [InvoicesController::class, 'index'])->name('index');
    Route::get('/create', [InvoicesController::class, 'create'])->name('create');
    Route::post('/store', [InvoicesController::class, 'store'])->name('store');
    Route::get('/status-show/{id}', [InvoicesController::class, 'show'])->name('status-show');
    Route::get('/edit/{id}', [InvoicesController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [InvoicesController::class, 'update'])->name('update');
    Route::post('/status-update/{id}', [InvoicesController::class, 'statusUpdate'])->name('status-update');
    Route::delete('/destroy/{id}', [InvoicesController::class, 'destroy'])->name('destroy');
    Route::get('invoice-paid', [InvoicesController::class, 'invoicePaid'])->name('invoice-paid');
    Route::get('invoice-unpaid', [InvoicesController::class, 'invoiceUnPaid'])->name('invoice-unpaid');
    Route::get('invoice-partial', [InvoicesController::class, 'invoicePartial'])->name('invoice-partial');
    Route::get('invoice-print/{id}', [InvoicesController::class, 'invoicePrint'])->name('invoice-print');

    Route::get('view-archive', [InvoicesArchivController::class, 'index'])->name('view-archive');
    Route::delete('delete-archive', [InvoicesArchivController::class, 'destroy'])->name('delete-archive');
    Route::patch('update-archive', [InvoicesArchivController::class, 'update'])->name('update-archive');
});

Route::get('/sections/{id}', [InvoicesController::class, 'getProducts'])->name('getproducts');

Route::get('/invoice-details/{id}', [InvoicesDetailsController::class, 'edit'])->name('invoice-details');
Route::get('/view-file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'openFile'])->name('view-file');
Route::get('/download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'getFile'])->name('download');
Route::post('/delete-file', [InvoicesDetailsController::class, 'destroy'])->name('delete-file');
Route::post('/invoice-attachment', [InvoicesAttachmentController::class, 'store'])->name('invoice-attachment');

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
