<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\FilamentColorController;
use App\Http\Controllers\FilamentController;
use App\Http\Controllers\FilamentTypeController;
use App\Http\Controllers\FilamentUsageController;
use App\Http\Controllers\PrintedItemController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\UserPrinterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Welcome', [
        'filamentRolls' => auth()->user()?->filamentRolls,
        'user' => auth()->user(),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('Dashboard', [
            'filamentRolls' => auth()->user()->filamentRolls,
        ]);
    })->name('dashboard');

    // Printer routes (shared printer database)
    Route::prefix('3d-printers')->group(function () {
        Route::get('', [PrinterController::class, 'index'])->name('printers.index');
        Route::get('create', [PrinterController::class, 'create'])->name('printers.create');
        Route::post('', [PrinterController::class, 'store'])->name('printers.store');
        Route::get('{printer}/edit', [PrinterController::class, 'edit'])->name('printers.edit');
        Route::patch('{printer}', [PrinterController::class, 'update'])->name('printers.update');
        Route::delete('{printer}', [PrinterController::class, 'destroy'])->name('printers.destroy');
    });

    // UserPrinter routes (user's personal printer collection)
    Route::prefix('printers')->group(function () {
        Route::get('', [UserPrinterController::class, 'index'])->name('user-printers.index');
        Route::get('create', [UserPrinterController::class, 'create'])->name('user-printers.create');
        Route::post('', [UserPrinterController::class, 'store'])->name('user-printers.store');
        Route::get('{userPrinter}', [UserPrinterController::class, 'show'])->name('user-printers.show');
        Route::get('{userPrinter}/edit', [UserPrinterController::class, 'edit'])->name('user-printers.edit');
        Route::patch('{userPrinter}', [UserPrinterController::class, 'update'])->name('user-printers.update');
        Route::delete('{userPrinter}', [UserPrinterController::class, 'destroy'])->name('user-printers.destroy');
        Route::post('{userPrinter}/assign-filament', [UserPrinterController::class, 'assignFilament'])->name('user-printers.assign-filament');
    });

    Route::prefix('filaments')->group(function () {
        Route::get('', [FilamentController::class, 'index'])->name('filament.index');
        Route::get('create', [FilamentController::class, 'create'])->name('filament.create');
        Route::get('color', [FilamentColorController::class, 'show'])->name('filament.show-color');
        Route::get('{filamentRoll}', [FilamentController::class, 'show'])->name('filament.show');
        Route::post('', [FilamentController::class, 'store'])->name('filament.store');
        Route::delete('destroy/{filamentRoll}', [FilamentController::class, 'destroy'])->name('filament.destroy');
        Route::post('use', [FilamentUsageController::class, 'store'])->name('filament.use');
    });

    Route::prefix('prints')->group(function () {
        Route::get('', [PrintedItemController::class, 'index'])->name('print.index');
        Route::get('create', [PrintedItemController::class, 'create'])->name('print.create');
        Route::get('{printedItem}', [PrintedItemController::class, 'show'])->name('print.show');
        Route::post('', [PrintedItemController::class, 'store'])->name('print.store');
        Route::delete('destroy/{printedItem}', [PrintedItemController::class, 'destroy'])->name('print.destroy');
    });

    Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
    Route::post('colors', [ColorController::class, 'store'])->name('colors.store');
    Route::post('filament-types', [FilamentTypeController::class, 'store'])->name('filament-types.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
