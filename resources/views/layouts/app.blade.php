<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EnvLab Tracker')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 font-sans text-slate-800 antialiased">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="hidden w-64 shrink-0 flex-col bg-royal text-white md:flex">
        <div class="flex items-center gap-3 px-6 py-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand font-bold text-white">EL</div>
            <div>
                <p class="text-sm font-bold leading-tight">EnvLab</p>
                <p class="text-xs text-white/70">Tracker</p>
            </div>
        </div>
        <nav class="flex-1 space-y-1 px-3">
            @php
                $isDashboard = request()->routeIs('dashboard');
                $isData = request()->routeIs('data-sampels.*');
            @endphp
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ $isDashboard ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg transition {{ $isDashboard ? 'bg-brand text-white' : 'bg-white/10 text-white/70' }}">
                    <x-heroicon-o-squares-2x2 class="h-5 w-5" />
                </span>
                <span>Dashboard</span>
                @if ($isDashboard)
                    <span class="ml-auto h-2 w-2 rounded-full bg-brand"></span>
                @endif
            </a>
            <a href="{{ route('data-sampels.index') }}"
               class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition {{ $isData ? 'bg-white/15 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg transition {{ $isData ? 'bg-brand text-white' : 'bg-white/10 text-white/70' }}">
                    <x-heroicon-o-clipboard-document-list class="h-5 w-5" />
                </span>
                <span>Data Sampel</span>
                @if ($isData)
                    <span class="ml-auto h-2 w-2 rounded-full bg-brand"></span>
                @endif
            </a>
        </nav>
        <div class="space-y-2 p-4">
            <div class="rounded-lg bg-white/10 p-4 text-xs text-white/80">
                <p class="font-semibold text-white">{{ Auth::user()->name ?? 'Lab Lingkungan' }}</p>
                <p class="mt-1 break-all">{{ Auth::user()->email ?? '' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-white/70 transition hover:bg-white/10 hover:text-white">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                        <x-heroicon-o-arrow-left-start-on-rectangle class="h-5 w-5" />
                    </span>
                    <span>Keluar</span>
                </button>
            </form>
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
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-lg px-3 py-1.5 text-slate-600">Keluar</button>
                </form>
            </nav>
            <div class="hidden md:block">
                <p class="text-sm font-semibold text-royal">@yield('page-title', 'Dashboard')</p>
                <p class="text-xs text-slate-500">@yield('page-subtitle', '')</p>
            </div>
            <div class="hidden items-center gap-3 sm:flex">
                <div class="text-right">
                    <p class="text-xs font-semibold text-slate-700">{{ Auth::user()->name ?? '' }}</p>
                    <a href="{{ route('profile.edit') }}" class="text-[11px] text-slate-400 hover:text-royal">Profil</a>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-brand/20 text-sm font-bold text-royal-dark">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
            </div>
        </header>

        @isset($header)
            <div class="border-b border-slate-200 bg-white px-4 py-3 sm:px-8">
                {{ $header }}
            </div>
        @endisset

        <!-- Toasts -->
        <div id="toast-container" class="pointer-events-none fixed bottom-4 right-4 z-[70] flex w-[calc(100%-2rem)] max-w-sm flex-col gap-2">
            @if (session('success'))
                <div class="pointer-events-auto flex items-start gap-3 rounded-lg border border-brand/40 bg-white px-4 py-3" role="alert" data-toast data-toast-timeout="4500">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand/15 text-emerald-700">
                        <x-heroicon-o-check-circle class="h-5 w-5" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-slate-800">Berhasil</p>
                        <p class="mt-0.5 text-xs text-slate-500">{{ session('success') }}</p>
                        <div class="mt-2 h-1 overflow-hidden rounded-full bg-slate-100">
                            <div class="toast-progress h-full w-full origin-left rounded-full bg-brand"></div>
                        </div>
                    </div>
                    <button type="button" class="rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600" data-dismiss-alert aria-label="Tutup">
                        <x-heroicon-o-x-mark class="h-4 w-4" />
                    </button>
                </div>
            @endif
            @if (session('status'))
                <div class="pointer-events-auto flex items-start gap-3 rounded-lg border border-royal/30 bg-white px-4 py-3" role="alert" data-toast data-toast-timeout="4500">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-royal/10 text-royal">
                        <x-heroicon-o-information-circle class="h-5 w-5" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-slate-800">Info</p>
                        <p class="mt-0.5 text-xs text-slate-500">{{ session('status') }}</p>
                        <div class="mt-2 h-1 overflow-hidden rounded-full bg-slate-100">
                            <div class="toast-progress h-full w-full origin-left rounded-full bg-royal"></div>
                        </div>
                    </div>
                    <button type="button" class="rounded-lg p-1 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600" data-dismiss-alert aria-label="Tutup">
                        <x-heroicon-o-x-mark class="h-4 w-4" />
                    </button>
                </div>
            @endif
        </div>

        <!-- Content -->
        <main class="flex-1 px-4 py-6 sm:px-8">
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>
