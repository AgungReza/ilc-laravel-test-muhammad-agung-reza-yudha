<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoodsIssueController;
use App\Http\Controllers\GoodsReceiptController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemSupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Route untuk User yang Sudah Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', CategoryController::class)
        ->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Item
    |--------------------------------------------------------------------------
    */

    Route::resource('items', ItemController::class);

    /*
    |--------------------------------------------------------------------------
    | Kelola Supplier per Barang (item_supplier)
    |--------------------------------------------------------------------------
    */

    Route::get('items/{item}/suppliers/create', [ItemSupplierController::class, 'create'])
        ->name('items.suppliers.create');

    Route::post('items/{item}/suppliers', [ItemSupplierController::class, 'store'])
        ->name('items.suppliers.store');

    Route::get('items/{item}/suppliers/{supplier}/edit', [ItemSupplierController::class, 'edit'])
        ->name('items.suppliers.edit');

    Route::put('items/{item}/suppliers/{supplier}', [ItemSupplierController::class, 'update'])
        ->name('items.suppliers.update');

    Route::delete('items/{item}/suppliers/{supplier}', [ItemSupplierController::class, 'destroy'])
        ->name('items.suppliers.destroy');

    /*
    |--------------------------------------------------------------------------
    | Supplier
    |--------------------------------------------------------------------------
    */

    Route::resource('suppliers', SupplierController::class);

    /*
    |--------------------------------------------------------------------------
    | Barang Masuk (Goods Receipt)
    |--------------------------------------------------------------------------
    */

    Route::resource('goods-receipts', GoodsReceiptController::class)
        ->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Barang Keluar (Goods Issue)
    |--------------------------------------------------------------------------
    */

    Route::resource('goods-issues', GoodsIssueController::class)
        ->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Route Khusus Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin-test', function () {
        return 'Berhasil masuk sebagai admin.';
    })->name('admin.test');

    Route::resource('users', UserController::class)
        ->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
