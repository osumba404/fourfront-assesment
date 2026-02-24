<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Create a new wallet for a user.
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'initial_balance' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['currency_code'] = strtoupper($validated['currency_code'] ?? 'USD');
        $validated['initial_balance'] = $validated['initial_balance'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? true;

        $wallet = Wallet::query()->create($validated);

        return response()->json([
            'message' => 'Wallet created successfully.',
            'data' => $wallet->loadMissing('user:id,name,email'),
        ], 201);
    }

    /**
     * Display a single wallet: balance and all transactions.
     *
     * @return JsonResponse
     */
    public function show(Wallet $wallet): JsonResponse
    {
        $wallet->load(['transactions' => fn ($q) => $q->orderBy('transaction_date', 'desc')->orderBy('id', 'desc')]);

        return response()->json([
            'data' => [
                'id' => $wallet->id,
                'user_id' => $wallet->user_id,
                'name' => $wallet->name,
                'currency_code' => $wallet->currency_code,
                'initial_balance' => (float) $wallet->initial_balance,
                'balance' => round((float) $wallet->balance, 2),
                'is_active' => $wallet->is_active,
                'description' => $wallet->description,
                'transactions' => $wallet->transactions->map(fn ($t) => [
                    'id' => $t->id,
                    'type' => $t->type,
                    'amount' => (float) $t->amount,
                    'description' => $t->description,
                    'transaction_date' => $t->transaction_date->format('Y-m-d'),
                    'reference' => $t->reference,
                    'created_at' => $t->created_at->toIso8601String(),
                ]),
                'created_at' => $wallet->created_at->toIso8601String(),
            ],
        ]);
    }
}
