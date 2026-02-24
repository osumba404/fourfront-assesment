<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Add an income or expense transaction to a wallet.
     * Income adds to balance; expense subtracts from balance.
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'wallet_id' => ['required', 'integer', 'exists:wallets,id'],
            'type' => ['required', 'string', 'in:'.implode(',', Transaction::$types)],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:500'],
            'transaction_date' => ['required', 'date'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        $transaction = Transaction::query()->create($validated);
        $transaction->load('wallet:id,name,currency_code');

        return response()->json([
            'message' => 'Transaction created successfully.',
            'data' => [
                'id' => $transaction->id,
                'wallet_id' => $transaction->wallet_id,
                'type' => $transaction->type,
                'amount' => (float) $transaction->amount,
                'description' => $transaction->description,
                'transaction_date' => $transaction->transaction_date->format('Y-m-d'),
                'reference' => $transaction->reference,
                'created_at' => $transaction->created_at->toIso8601String(),
            ],
        ], 201);
    }
}
