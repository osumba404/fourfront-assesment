@extends('layouts.app')

@section('title', $wallet->name . ' — Wallet')

@section('content')
    <div class="mb-6">
        <a href="{{ route('users.show', $wallet->user) }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600">&larr; {{ $wallet->user->name }} profile</a>
    </div>

    <div class="space-y-6">
        {{-- Wallet summary --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            <h1 class="text-xl font-semibold text-slate-800">{{ $wallet->name }}</h1>
            <p class="mt-1 text-sm text-slate-600">{{ $wallet->currency_code }} · {{ $wallet->user->name }}</p>
            <p class="mt-4 text-2xl font-semibold {{ (float) $wallet->balance >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                Balance: {{ number_format((float) $wallet->balance, 2) }} {{ $wallet->currency_code }}
            </p>
        </div>

        {{-- Add transaction --}}
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-medium text-slate-800">Add transaction</h2>
            <form action="{{ route('transactions.store') }}" method="post" class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
                @csrf
                <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">

                <div>
                    <label for="type" class="block text-sm font-medium text-slate-700">Type</label>
                    <select name="type" id="type" required
                        class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                        <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Income</option>
                        <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Expense</option>
                    </select>
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-slate-700">Amount</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0.01" step="0.01"
                        class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 @error('amount') border-red-500 @enderror">
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="transaction_date" class="block text-sm font-medium text-slate-700">Date</label>
                    <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required
                        class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 @error('transaction_date') border-red-500 @enderror">
                    @error('transaction_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 sm:w-auto">
                        Add
                    </button>
                </div>

                <div class="sm:col-span-2 lg:col-span-4">
                    <label for="description" class="block text-sm font-medium text-slate-700">Description (optional)</label>
                    <input type="text" name="description" id="description" value="{{ old('description') }}" placeholder="e.g. Salary, Groceries"
                        class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                </div>
            </form>
        </div>

        {{-- Transactions list --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-4 py-3 sm:px-6">
                <h2 class="text-lg font-medium text-slate-800">Transactions</h2>
            </div>
            @if ($wallet->transactions->isEmpty())
                <div class="px-4 py-8 text-center text-slate-500 sm:px-6">
                    No transactions yet. Add one above.
                </div>
            @else
                <ul class="divide-y divide-slate-200">
                    @foreach ($wallet->transactions as $tx)
                        <li class="flex items-center justify-between px-4 py-3 sm:px-6">
                            <div>
                                <span class="font-medium {{ $tx->type === 'income' ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ $tx->type === 'income' ? '+' : '−' }}{{ number_format((float) $tx->amount, 2) }} {{ $wallet->currency_code }}
                                </span>
                                <span class="ml-2 text-slate-600">{{ $tx->description ?: '—' }}</span>
                                <span class="ml-2 text-sm text-slate-400">{{ $tx->transaction_date->format('M j, Y') }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
