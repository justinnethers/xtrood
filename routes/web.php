<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\FilamentController;
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

Route::prefix('filament')->middleware(['auth', 'verified'])->group(function () {
    Route::get('', [FilamentController::class, 'index'])->name('filament.index');
    Route::get('create', [FilamentController::class, 'create'])->name('filament.create');
    Route::post('', [FilamentController::class, 'store'])->name('filament.store');
    Route::delete('destroy/{filamentRoll}', [FilamentController::class, 'destroy'])->name('filament.destroy');
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
