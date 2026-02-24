<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('dashboard'))->name('dashboard');

// User: create account, view profile
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/profile', [UserController::class, 'showForm'])->name('users.show.form');

// Wallet: create, view (balance + transactions)
Route::get('/wallets/create', [WalletController::class, 'create'])->name('wallets.create');
Route::post('/wallets', [WalletController::class, 'store'])->name('wallets.store');
Route::get('/wallets/{wallet}', [WalletController::class, 'show'])->name('wallets.show');
Route::get('/wallet', [WalletController::class, 'showForm'])->name('wallets.show.form');

// Transaction: add income/expense (form on wallet show page)
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
