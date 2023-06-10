<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});






Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    

    Route::middleware('user-access:admin')->group(function () {
        Route::resource('posts', PostController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy']);
    });

    Route::middleware('user-access:user')->group(function () {
        // Routes accessible to "user" users only
        // Add any specific routes or middleware for user here
    });

    Route::middleware('user-access:manager')->group(function () {
        Route::resource('posts', PostController::class)
        ->only(['index', 'store', 'edit', 'update', 'destroy']);
    });
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
