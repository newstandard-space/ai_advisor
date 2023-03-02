<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatGptController;
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

// Home画面
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

// ChatGpt接続系
Route::middleware('auth')->group(function () {
    Route::put('/generate', [ChatGptController::class, 'generate'])->name('generate');
    Route::get('/getAll', [ChatGptController::class, 'getAll'])->name('getAll');
    Route::get('/clearSession', [ChatGptController::class, 'clearSession'])->name('clearSession');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';