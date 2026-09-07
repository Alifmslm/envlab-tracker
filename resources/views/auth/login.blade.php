@extends('layouts.guest')

@section('title', 'Masuk - EnvLab Tracker')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-slate-100 px-4 py-12">
    <div class="w-full max-w-md overflow-hidden rounded-lg bg-white">
        <div class="bg-royal px-8 py-6 text-white">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-brand font-bold text-white">EL</div>
                <div>
                    <p class="text-base font-bold leading-tight">EnvLab Tracker</p>
                    <p class="text-xs text-white/70">Monitoring Sampel Lab Lingkungan</p>
                </div>
            </div>
        </div>

        <div class="px-8 py-7">
            <h2 class="text-xl font-bold text-royal">Selamat datang kembali</h2>
            <p class="mt-1 text-sm text-slate-500">Masuk untuk lanjut ke dashboard.</p>

            <div class="mt-4 rounded-lg border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-xs text-slate-500">
                Prototype: tombol Masuk langsung membuka
                <a href="{{ route('dashboard') }}" class="font-semibold text-royal underline">dashboard</a>.
                Breeze akan dipasang nanti.
            </div>

            <form action="{{ route('dashboard') }}" method="GET" class="mt-6 space-y-4">
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" type="email" placeholder="nama@lab.go.id"
                           class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" type="password" placeholder="••••••••"
                           class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 accent-[#00D97A]">
                        Ingat saya
                    </label>
                    <span class="text-slate-400">Lupa password?</span>
                </div>
                <button type="submit"
                        class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-bold text-white transition hover:bg-brand-dark active:translate-y-px">
                    Masuk
                </button>
            </form>

            <div class="mt-6 flex items-center justify-center gap-3 text-xs text-slate-400">
                <a href="{{ route('dashboard') }}" class="hover:text-royal">Dashboard</a>
                <span>•</span>
                <a href="{{ route('data-sampels.index') }}" class="hover:text-royal">Data Sampel</a>
            </div>
        </div>
    </div>
</div>
@endsection
