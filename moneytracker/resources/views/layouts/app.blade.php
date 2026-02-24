<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Money Tracker') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 font-sans antialiased">
    <nav class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-14 items-center justify-between">
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-slate-800 hover:text-indigo-600">
                    Money Tracker
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('users.create') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600">New user</a>
                    <a href="{{ route('wallets.create') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600">New wallet</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
