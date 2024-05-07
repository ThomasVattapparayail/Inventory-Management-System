<?php
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\LoginController::class, 'login']);
 Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/inventory/generateReport', [InventoryItemController::class, 'exportToCSV'])->name('inventory.report');
    Route::get('/inventory/tracker', [InventoryItemController::class, 'inventoryTracker'])->name('inventory.tracker');

    Route::middleware(['adminOnly'])->group(function () {
        Route::get('/inventory-items/create', [InventoryItemController::class, 'index'])->name('inventory-items.create');
        Route::post('/inventory-items', [InventoryItemController::class, 'store'])->name('inventory-items.store');
        Route::get('/inventory-items/{inventoryItem}/edit', [InventoryItemController::class, 'edit'])->name('inventory-items.edit');
        Route::put('/inventory-items/{inventoryItem}', [InventoryItemController::class, 'update'])->name('inventory-items.update');
        Route::delete('/inventory-items/{inventoryItem}', [InventoryItemController::class, 'destroy'])->name('inventory-items.destroy');
        Route::post('/inventory/update/{id}', [InventoryItemController::class, 'inventoryUpdate'])->name('inventory.update');
        Route::post('/import-inventory-csv', [InventoryItemController::class, 'importFromCSV'])->name('import.inventory.csv');
        Route::post('/mark-notification/{id}', [HomeController::class, 'markNotification'])->name('mark.notification');
        Route::post('/mark-all-notifications', [HomeController::class, 'markAllNotification'])->name('mark.all.notifications');

    });
});

