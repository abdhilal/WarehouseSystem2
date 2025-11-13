<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\FactoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\FileController;


Route::get('/locale/{locale}', function (string $locale) {
    if (!in_array($locale, ['ar', 'en'])) {
        abort(404);
    }
    session(['locale' => $locale]);
    return back();
})->name('locale.switch');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', function () {
    return view('pages.welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/warehouses', WarehouseController::class);
    Route::resource('/areas', AreaController::class);
    Route::resource('/factories', FactoryController::class);
    Route::resource('/representatives', RepresentativeController::class);
    Route::resource('/pharmacies', PharmacyController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/transactions', TransactionController::class);
    Route::get('/users/permissions', [UserPermissionController::class, 'manage'])->name('users.permissions.manage');
    Route::post('/users/{user}/permissions', [UserPermissionController::class, 'update'])
        ->name('users.permissions.update');

    Route::get('/files/export', [FileController::class, 'export'])->name('files.export');
    Route::post('/files/store', [FileController::class, 'store'])->name('files.store');


    Route::view('/files/upload', 'pages.files.partials.create')->name('files.upload');
});

require __DIR__ . '/auth.php';
