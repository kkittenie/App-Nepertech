<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;


Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::get('/', [HomeController::class, 'beranda'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/layanan', [HomeController::class, 'layanan']);
Route::get('/fasilitas', [HomeController::class, 'fasilitas']);
Route::get('/project', [HomeController::class, 'project'])->name('project');
Route::get('/project/{slug}', [HomeController::class, 'projectDetail'])->name('project.detail');
Route::get('/kontak', [HomeController::class, 'kontak']);
Route::post('/rental/request', [\App\Http\Controllers\RentalController::class, 'store'])->name('rental.request');
Route::get('/rental/payment/{token}', [\App\Http\Controllers\RentalController::class, 'paymentPage'])->name('rental.payment');
Route::post('/rental/payment/{token}', [\App\Http\Controllers\RentalController::class, 'submitPayment'])->name('rental.payment.submit');
Route::post('/sale/request', [SaleController::class, 'store'])->name('sale.request');
Route::get('/sale/payment/{token}', [SaleController::class, 'paymentPage'])->name('sale.payment');
Route::post('/sale/payment/{token}', [SaleController::class, 'submitPayment'])->name('sale.payment.submit');

Route::middleware('auth')->group(function () {

  
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');


    Route::get('/dashboard', [DashboardAdminController::class, 'index'])
        ->middleware('admin')
        ->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('products')->name('products.')->group(function () {

        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');

        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('kategori')->name('kategori.')->group(function () {

    Route::get('/', [KategoriController::class, 'index'])->name('index');
    Route::get('/create', [KategoriController::class, 'create'])->name('create');
    Route::post('/', [KategoriController::class, 'store'])->name('store');

    Route::get('/{kategori}/edit', [KategoriController::class, 'edit'])->name('edit');
    Route::put('/{kategori}', [KategoriController::class, 'update'])->name('update');

    Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');

});


    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
    });

    Route::prefix('admin/rentals')->name('admin.rentals.')->middleware('admin')->group(function () {
        Route::get('/', [\App\Http\Controllers\RentalController::class, 'index'])->name('index');
        Route::post('/{rental}/approve', [\App\Http\Controllers\RentalController::class, 'approve'])->name('approve');
        Route::post('/{rental}/reject', [\App\Http\Controllers\RentalController::class, 'reject'])->name('reject');
        Route::post('/{rental}/remind', [\App\Http\Controllers\RentalController::class, 'remind'])->name('remind');
        Route::post('/{rental}/approve-payment', [\App\Http\Controllers\RentalController::class, 'approvePayment'])->name('approvePayment');
    });

    Route::prefix('admin/sales')->name('admin.sales.')->middleware('admin')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::post('/{sale}/approve', [SaleController::class, 'approve'])->name('approve');
        Route::post('/{sale}/reject', [SaleController::class, 'reject'])->name('reject');
        Route::post('/{sale}/approve-payment', [SaleController::class, 'approvePayment'])->name('approvePayment');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});