@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-slate-800">Dashboard</h1>
        <p class="mt-1 text-slate-600">Create users and wallets, then view profiles and add transactions.</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2">
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-medium text-slate-800">Users</h2>
            <p class="mt-2 text-sm text-slate-600">Create an account or view a user's profile (wallets and total balance).</p>
            <div class="mt-4 flex gap-3">
                <a href="{{ route('users.create') }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                    Create user
                </a>
                <form action="{{ route('users.show.form') }}" method="get" class="flex gap-2">
                    <input type="number" name="id" min="1" placeholder="User ID" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500">
                    <button type="submit" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    View profile
                    </button>
                </form>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-medium text-slate-800">Wallets</h2>
            <p class="mt-2 text-sm text-slate-600">Create a wallet or open one to see balance and transactions.</p>
            <div class="mt-4 flex gap-3">
                <a href="{{ route('wallets.create') }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                    Create wallet
                </a>
                <form action="{{ route('wallets.show.form') }}" method="get" class="flex gap-2">
                    <input type="number" name="id" min="1" placeholder="Wallet ID" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-green-500 focus:ring-1 focus:ring-green-500">
                    <button type="submit" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    View wallet
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
