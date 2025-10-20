<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\MaterialImportController;
use App\Http\Controllers\MaterialUsageController;
use App\Http\Middleware\IpWhitelist;

require __DIR__.'/auth.php';

// Halaman login
Route::get('/', function () {
    return view('auth.login'); // pastikan view auth.login ada
});

// Semua route wajib login + IP whitelist
Route::middleware(['auth', IpWhitelist::class])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Work Orders
    Route::get('/workorders/create', [WorkOrderController::class, 'create'])->name('workorders.create');
    Route::post('/workorders', [WorkOrderController::class, 'store'])->name('workorders.store');
    Route::get('/workorders', [WorkOrderController::class, 'index'])->name('workorders.index');
    Route::get('/workorders/{id}', [WorkOrderController::class, 'show'])->name('workorders.show');
    Route::get('/workorders/{id}/edit', [WorkOrderController::class, 'edit'])->name('workorders.edit');
    Route::put('/workorders/{id}', [WorkOrderController::class, 'update'])->name('workorders.update');
    Route::delete('/workorders/{id}', [WorkOrderController::class, 'destroy'])->name('workorders.destroy');
    Route::get('/workorders/pdf/{id}', [WorkOrderController::class, 'exportPDF'])->name('workorders.pdf');

    // Material Import
    Route::get('/import-material', [MaterialImportController::class, 'showForm'])->name('material.import.form');
    Route::post('/import-material', [MaterialImportController::class, 'import'])->name('material.import');
    Route::get('/materials/search', [WorkOrderController::class, 'searchMaterial'])->name('material.search');

    // Material Usage
    Route::get('/pemakaian-material', [MaterialUsageController::class, 'index'])->name('pemakaian-material.index');
    Route::get('/pemakaian-material/{material_no}', [MaterialUsageController::class, 'detail'])->name('pemakaian-material.detail');

});
