<?php

use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Money Tracker API Routes
|--------------------------------------------------------------------------
|
| All routes are prefixed with /api (e.g. /api/users, /api/wallets).
|
*/

// User: create account, view profile (all wallets + balances + total)
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);

// Wallet: create wallet, view single wallet (balance + transactions)
Route::post('/wallets', [WalletController::class, 'store']);
Route::get('/wallets/{wallet}', [WalletController::class, 'show']);

// Transaction: add income or expense to a wallet
Route::post('/transactions', [TransactionController::class, 'store']);
