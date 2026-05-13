<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CltLayupController;
use App\Http\Controllers\CltLayerController;
use App\Http\Controllers\SupplierImportExportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('suppliers', SupplierController::class);
    Route::resource('suppliers.layups', CltLayupController::class);
    Route::resource('suppliers.layups.layers', CltLayerController::class);

    Route::get('/suppliers/{supplier}/export', [SupplierImportExportController::class, 'export'])->name('suppliers.export');
    Route::post('/suppliers/{supplier}/import', [SupplierImportExportController::class, 'import'])->name('suppliers.import');

    Route::get('/suppliers/{supplier}/import/conflicts', [SupplierImportExportController::class, 'conflicts'])->name('suppliers.import.conflicts');
    Route::post('/suppliers/{supplier}/import/resolve', [SupplierImportExportController::class, 'resolve'])->name('suppliers.import.resolve');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
