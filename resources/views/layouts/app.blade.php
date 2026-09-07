<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EnvLab Tracker')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="hidden w-64 shrink-0 flex-col bg-royal text-white md:flex">
        <div class="flex items-center gap-3 px-6 py-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand font-bold text-royal-dark">EL</div>
            <div>
                <p class="text-sm font-bold leading-tight">EnvLab</p>
                <p class="text-xs text-white/70">Tracker</p>
            </div>
        </div>
        <nav class="flex-1 space-y-1 px-3">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'border-l-4 border-brand bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('data-sampels.index') }}"
               class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition {{ request()->routeIs('data-sampels.*') ? 'border-l-4 border-brand bg-white/15 text-white' : 'text-white/75 hover:bg-white/10 hover:text-white' }}">
                <span>Data Sampel</span>
            </a>
        </nav>
        <div class="p-4">
            <div class="rounded-xl bg-white/10 p-4 text-xs text-white/80">
                <p class="font-semibold text-white">Lab Lingkungan</p>
                <p class="mt-1">Prototype UI. Auth Breeze menyusul.</p>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex min-w-0 flex-1 flex-col">
        <!-- Topbar -->
        <header class="flex items-center justify-between gap-4 border-b border-slate-200 bg-white px-4 py-3 sm:px-8">
            <div class="flex items-center gap-3 md:hidden">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-royal font-bold text-white">EL</div>
            </div>
            <nav class="flex items-center gap-2 text-sm md:hidden">
                <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('dashboard') ? 'bg-royal text-white' : 'text-slate-600' }}">Dashboard</a>
                <a href="{{ route('data-sampels.index') }}" class="rounded-lg px-3 py-1.5 {{ request()->routeIs('data-sampels.*') ? 'bg-royal text-white' : 'text-slate-600' }}">Data</a>
            </nav>
            <div class="hidden md:block">
                <p class="text-sm font-semibold text-royal">@yield('page-title', 'Dashboard')</p>
                <p class="text-xs text-slate-500">@yield('page-subtitle', '')</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden text-xs text-slate-400 sm:block">Login (prototype)</a>
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand/20 text-sm font-bold text-royal-dark">A</div>
            </div>
        </header>

        <!-- Flash -->
        @if (session('success'))
            <div class="mx-4 mt-4 rounded-xl border border-brand/40 bg-brand/10 px-4 py-3 text-sm font-medium text-emerald-800 sm:mx-8">
                {{ session('success') }}
            </div>
        @endif

        <!-- Content -->
        <main class="flex-1 px-4 py-6 sm:px-8">
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
