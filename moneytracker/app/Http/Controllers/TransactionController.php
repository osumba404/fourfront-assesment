<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Store a newly created transaction (income or expense).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'wallet_id' => ['required', 'integer', 'exists:wallets,id'],
            'type' => ['required', 'string', 'in:'.implode(',', Transaction::$types)],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:500'],
            'transaction_date' => ['required', 'date'],
            'reference' => ['nullable', 'string', 'max:255'],
        ]);

        Transaction::query()->create($validated);

        return redirect()
            ->route('wallets.show', $validated['wallet_id'])
            ->with('success', 'Transaction added.');
    }
}
