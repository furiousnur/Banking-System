<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
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

Route::get('/', [UserController::class,'index'])->name('/');
Route::post('/login', [UserController::class,'login'])->name('login');
Route::get('/users/create', [UserController::class,'create'])->name('users.create');
Route::post('/users/store', [UserController::class,'store'])->name('users.store');
Route::post('logout', [UserController::class,'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('transactions', TransactionController::class);
    Route::resource('deposit', DepositController::class);
    Route::resource('withdrawal', WithdrawalController::class);
});
