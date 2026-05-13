<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

<<<<<<< HEAD
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;


Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login',
        [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login',
        [AuthController::class, 'login'])
        ->name('login.process');

    // Register
    Route::get('/register',
        [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register',
        [AuthController::class, 'register'])
        ->name('register.process');

});
=======
Route::get('/', [HomeController::class, 'beranda']);
Route::get('/profil', [HomeController::class, 'profil']);
Route::get('/layanan', [HomeController::class, 'layanan']);
Route::get('/fasilitas', [HomeController::class, 'fasilitas']);
Route::get('/galeri', [HomeController::class, 'galeri']);
Route::get('/kontak', [HomeController::class, 'kontak']);
Route::get('/pendaftaran', [HomeController::class, 'pendaftaran'])
    ->middleware('auth');
>>>>>>> 2ea55c39820059a9ac9ce1ce4c889bd8ce38a487

Route::post('/logout',
    [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');



Route::middleware('auth')->group(function () {
<<<<<<< HEAD

    Route::get('/',
        [DashboardAdminController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard',
        [DashboardAdminController::class, 'index'])
        ->name('dashboard.index');

    Route::prefix('inventory')
        ->name('inventory.')
        ->group(function () {

        Route::get('/',
            [InventoryController::class, 'index'])
            ->name('index');

    });



    Route::prefix('products')
        ->name('products.')
        ->group(function () {

        // Create
        Route::get('/create',
            [ProductController::class, 'create'])
            ->name('create');

        // Store
        Route::post('/',
            [ProductController::class, 'store'])
            ->name('store');

        // Edit
        Route::get('/{product}/edit',
            [ProductController::class, 'edit'])
            ->name('edit');

        // Update
        Route::put('/{product}',
            [ProductController::class, 'update'])
            ->name('update');

        // Delete
        Route::delete('/{product}',
            [ProductController::class, 'destroy'])
            ->name('destroy');

    });

    Route::prefix('reports')
        ->name('reports.')
        ->group(function () {

        Route::get('/',
            [ReportController::class, 'index'])
            ->name('index');

    });

});
=======
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo');
});

require __DIR__ . '/auth.php';
>>>>>>> 2ea55c39820059a9ac9ce1ce4c889bd8ce38a487
