@extends('layouts.app')

@section('title', 'Create wallet')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-green-600">&larr; Dashboard</a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
        <h1 class="text-xl font-semibold text-slate-800">Create wallet</h1>
        <p class="mt-1 text-sm text-slate-600">Assign a wallet to a user (e.g. Personal, Business).</p>

        <form action="{{ route('wallets.store') }}" method="post" class="mt-6 max-w-md space-y-4">
            @csrf

            <div>
                <label for="user_id" class="block text-sm font-medium text-slate-700">User</label>
                <select name="user_id" id="user_id" required
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('user_id') border-red-500 @enderror">
                    <option value="">Select user</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Wallet name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required placeholder="e.g. Personal, Business A"
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="currency_code" class="block text-sm font-medium text-slate-700">Currency</label>
                <input type="text" name="currency_code" id="currency_code" value="{{ old('currency_code', 'KES') }}" maxlength="3" placeholder="KES"
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('currency_code') border-red-500 @enderror">
                @error('currency_code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="initial_balance" class="block text-sm font-medium text-slate-700">Initial balance (optional)</label>
                <input type="number" name="initial_balance" id="initial_balance" value="{{ old('initial_balance', 0) }}" min="0" step="0.01"
                    class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 shadow-sm focus:border-green-500 focus:ring-1 focus:ring-green-500 @error('initial_balance') border-red-500 @enderror">
                @error('initial_balance')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                    Create wallet
                </button>
                <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
