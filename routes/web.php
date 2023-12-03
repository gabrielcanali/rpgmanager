<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
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

Route::get('/', [FrontController::class, 'index'])->name('index');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::post('authenticate', [DashboardController::class, 'authenticate'])->name('authenticate');

Route::get('logout', [DashboardController::class, 'logout'])->name('logout');

Route::get('login', function () { 
    return redirect()->to('/'); 
})->name('login');