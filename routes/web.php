<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\FilamentController;
use App\Http\Controllers\FilamentUsageController;
use App\Http\Controllers\PrintedItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'filamentRolls' => auth()->user()?->filamentRolls,
        'user' => auth()->user(),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard', [
            'filamentRolls' => auth()->user()->filamentRolls,
        ]);
    })->name('dashboard');
});

Route::prefix('filaments')->middleware(['auth', 'verified'])->group(function () {
    Route::get('', [FilamentController::class, 'index'])->name('filament.index');
    Route::get('create', [FilamentController::class, 'create'])->name('filament.create');
    Route::get('{filamentRoll}', [FilamentController::class, 'show'])->name('filament.show');
    Route::post('', [FilamentController::class, 'store'])->name('filament.store');
    Route::delete('destroy/{filamentRoll}', [FilamentController::class, 'destroy'])->name('filament.destroy');
    Route::post('use', [FilamentUsageController::class, 'store'])->name('filament.use');
});

Route::prefix('prints')->middleware(['auth', 'verified'])->group(function () {
    Route::get('', [PrintedItemController::class, 'index'])->name('print.index');
    Route::get('create', [PrintedItemController::class, 'create'])->name('print.create');
    Route::get('{printedItem}', [PrintedItemController::class, 'show'])->name('print.show');
    Route::post('', [PrintedItemController::class, 'store'])->name('print.store');
    Route::delete('destroy/{printedItem}', [PrintedItemController::class, 'destroy'])->name('print.destroy');
});


Route::post('brands', [BrandController::class, 'store'])
    ->middleware('auth')
    ->name('brands.store');

Route::post('colors', [ColorController::class, 'store'])
    ->middleware('auth')
    ->name('colors.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
