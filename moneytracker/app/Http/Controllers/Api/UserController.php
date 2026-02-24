<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new user account (no authentication required).
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            $validated['password'] = null;
        }

        $user = User::query()->create($validated);

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user->only(['id', 'name', 'email', 'created_at']),
        ], 201);
    }

    /**
     * Display the user profile: all wallets, each wallet's balance, and total balance.
     *
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        $user->load(['wallets' => fn ($q) => $q->active()->orderBy('name')]);

        $wallets = $user->wallets->map(fn ($wallet) => [
            'id' => $wallet->id,
            'name' => $wallet->name,
            'currency_code' => $wallet->currency_code,
            'balance' => round((float) $wallet->balance, 2),
            'is_active' => $wallet->is_active,
        ]);

        $totalBalance = round($user->wallets->sum(fn ($w) => (float) $w->balance), 2);

        return response()->json([
            'data' => [
                'user' => $user->only(['id', 'name', 'email', 'created_at']),
                'wallets' => $wallets,
                'total_balance' => $totalBalance,
            ],
        ]);
    }
}
