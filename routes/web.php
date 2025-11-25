<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FactoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\RepresentativeMedicalController;
use App\Http\Controllers\DashboardController;


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

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/stats', [DashboardController::class, 'stats'])
    ->middleware(['auth'])
    ->name('dashboard.stats');

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
    Route::resource('/representativesMedical', RepresentativeMedicalController::class);

    Route::get('/users/permissions', [UserController::class, 'managePermissions'])->name('users.permissions.manage');
    Route::post('/users/{user}/permissions', [UserController::class, 'updatePermissions'])
        ->name('users.permissions.update');
    Route::post('/users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
    Route::resource('/users', UserController::class);

    Route::delete('/files/destroy/{id}', [FileController::class, 'destroy'])->name('files.destroy');

    Route::get('/files/export', [FileController::class, 'export'])->name('files.export');
    Route::get('/files/index', [FileController::class, 'index'])->name('files.index');
    Route::post('/files/store', [FileController::class, 'store'])->name('files.store');
    Route::get('/files/download/{id}', [FileController::class, 'downloadFile'])->name('files.download');
    Route::get('/files/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::post('/files/filter', [FileController::class, 'FileFilter'])->name('files.filter');
});

require __DIR__ . '/auth.php';
