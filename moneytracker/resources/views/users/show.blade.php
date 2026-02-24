@extends('layouts.app')

@section('title', $user->name . ' — Profile')

@section('content')
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600">&larr; Dashboard</a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
        <h1 class="text-xl font-semibold text-slate-800">Profile</h1>
        <dl class="mt-4 grid gap-2 sm:grid-cols-2">
            <dt class="text-sm font-medium text-slate-500">Name</dt>
            <dd class="text-slate-800">{{ $user->name }}</dd>
            <dt class="text-sm font-medium text-slate-500">Email</dt>
            <dd class="text-slate-800">{{ $user->email }}</dd>
        </dl>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <h2 class="text-lg font-medium text-slate-800">Total balance</h2>
            <p class="mt-1 text-2xl font-semibold {{ $totalBalance >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                {{ number_format($totalBalance, 2) }} <span class="text-base font-normal text-slate-500">(across all wallets)</span>
            </p>
        </div>

        <div class="mt-8 border-t border-slate-200 pt-6">
            <h2 class="text-lg font-medium text-slate-800">Wallets</h2>
            @if ($wallets->isEmpty())
                <p class="mt-2 text-slate-600">No wallets yet. <a href="{{ route('wallets.create') }}" class="font-medium text-indigo-600 hover:underline">Create one</a>.</p>
            @else
                <ul class="mt-4 space-y-3">
                    @foreach ($wallets as $wallet)
                        <li class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50/50 px-4 py-3">
                            <div>
                                <a href="{{ route('wallets.show', $wallet) }}" class="font-medium text-slate-800 hover:text-indigo-600">{{ $wallet->name }}</a>
                                <span class="ml-2 text-sm text-slate-500">{{ $wallet->currency_code }}</span>
                            </div>
                            <span class="font-medium {{ (float) $wallet->balance >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ number_format((float) $wallet->balance, 2) }} {{ $wallet->currency_code }}
                            </span>
                            <a href="{{ route('wallets.show', $wallet) }}" class="ml-2 rounded bg-indigo-600 px-3 py-1 text-sm font-medium text-white hover:bg-indigo-700">View</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
