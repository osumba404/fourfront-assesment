<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WalletController extends Controller
{
    /**
     * Show the form for creating a new wallet.
     */
    public function create(): View
    {
        $users = User::query()->orderBy('name')->get(['id', 'name', 'email']);

        return view('wallets.create', ['users' => $users]);
    }

    /**
     * Store a newly created wallet.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'initial_balance' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['currency_code'] = strtoupper($validated['currency_code'] ?? 'KES');
        $validated['initial_balance'] = $validated['initial_balance'] ?? 0;
        $validated['is_active'] = true;

        $wallet = Wallet::query()->create($validated);

        return redirect()
            ->route('wallets.show', $wallet)
            ->with('success', 'Wallet created successfully.');
    }

    /**
     * Display the wallet (balance and transactions).
     */
    public function show(Wallet $wallet): View
    {
        $wallet->load(['user', 'transactions' => fn ($q) => $q->orderBy('transaction_date', 'desc')->orderBy('id', 'desc')]);

        return view('wallets.show', ['wallet' => $wallet]);
    }

    /**
     * Redirect to wallet by ID (for dashboard form).
     */
    public function showForm(Request $request): RedirectResponse
    {
        $request->validate(['id' => ['required', 'integer', 'exists:wallets,id']]);

        return redirect()->route('wallets.show', $request->id);
    }
}
