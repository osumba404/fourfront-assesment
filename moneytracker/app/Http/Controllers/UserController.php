<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * Store a newly created user (no authentication required).
     */
    public function store(Request $request): RedirectResponse
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

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the user profile (wallets, balances, total).
     */
    public function show(User $user): View
    {
        $user->load(['wallets' => fn ($q) => $q->active()->orderBy('name')]);
        $totalBalance = round($user->wallets->sum(fn ($w) => (float) $w->balance), 2);

        return view('users.show', [
            'user' => $user,
            'wallets' => $user->wallets,
            'totalBalance' => $totalBalance,
        ]);
    }

    /**
     * Redirect to user profile by ID (for dashboard form).
     */
    public function showForm(Request $request): RedirectResponse
    {
        $request->validate(['id' => ['required', 'integer', 'exists:users,id']]);

        return redirect()->route('users.show', $request->id);
    }
}
