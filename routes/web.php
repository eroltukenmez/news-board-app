<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomepageController::class)->name('homepage');

Route::get("/all",[NewsController::class,'all'])->name('news.all');
Route::get("/source/{source}",[NewsController::class,'sources'])->name('news.sources');
Route::get("/category/{category}",[NewsController::class,'category'])->name('news.category');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
