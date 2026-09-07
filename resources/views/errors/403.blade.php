<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Akses Ditolak - EnvLab Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">
<div class="flex min-h-screen items-center justify-center px-4 py-12">
    <div class="w-full max-w-md rounded-lg bg-white p-8 text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-lg bg-royal/10 text-royal">
            <x-heroicon-o-shield-exclamation class="h-7 w-7" />
        </div>
        <p class="mt-4 text-6xl font-bold tracking-tight text-royal">403</p>
        <h1 class="mt-2 text-xl font-bold text-slate-800">Akses Ditolak</h1>
        <p class="mt-2 text-sm text-slate-500">
            {{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}
        </p>
        @auth
            <p class="mt-3 inline-block rounded-full bg-royal/10 px-3 py-1 text-xs font-semibold text-royal">
                Masuk sebagai {{ auth()->user()->name }} ({{ auth()->user()->role === 'admin' ? 'Lab Head' : 'Analyst' }})
            </p>
        @endauth
        <div class="mt-6 flex flex-col gap-2 sm:flex-row sm:justify-center">
            <button type="button" onclick="history.back()"
                    class="rounded-lg border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                Kembali
            </button>
            @auth
                <a href="{{ route('dashboard') }}"
                   class="rounded-lg bg-royal px-5 py-2.5 text-sm font-bold text-white transition hover:bg-royal-dark">
                    Ke Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="rounded-lg bg-brand px-5 py-2.5 text-sm font-bold text-white transition hover:bg-brand-dark">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</div>
</body>
</html>
