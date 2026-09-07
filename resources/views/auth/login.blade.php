@extends('layouts.guest')

@section('title', 'Masuk - EnvLab Tracker')

@section('content')
<div class="flex min-h-screen flex-col md:flex-row">
    <!-- Left branding panel -->
    <div class="relative flex flex-1 flex-col justify-between overflow-hidden bg-royal px-8 py-10 text-white md:px-12">
        <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-16 h-72 w-72 rounded-full bg-brand/20"></div>
        <div class="relative flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand font-bold text-royal-dark">EL</div>
            <div>
                <p class="text-base font-bold leading-tight">EnvLab Tracker</p>
                <p class="text-xs text-white/70">Monitoring Sampel Lab Lingkungan</p>
            </div>
        </div>
        <div class="relative mt-10 grid gap-4 md:mt-0 md:max-w-md">
            <h1 class="text-2xl font-bold leading-snug md:text-3xl">Kelola sampel uji dalam satu dashboard.</h1>
            <p class="text-sm text-white/75">Pantau jenis sampel, total titik pengujian, dan estimasi tagihan secara real time.</p>
            <div class="grid grid-cols-3 gap-3 pt-2">
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-xl font-bold text-brand">5</p>
                    <p class="mt-1 text-[11px] leading-tight text-white/70">Jenis sampel terdaftar</p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-xl font-bold text-brand">17</p>
                    <p class="mt-1 text-[11px] leading-tight text-white/70">Titik pengujian</p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-xl font-bold text-brand">Rp</p>
                    <p class="mt-1 text-[11px] leading-tight text-white/70">Estimasi tagihan</p>
                </div>
            </div>
        </div>
        <p class="relative text-xs text-white/60">Prototype UI. Auth Breeze menyusul.</p>
    </div>

    <!-- Right form panel -->
    <div class="flex flex-1 items-center justify-center bg-white px-6 py-12">
        <div class="w-full max-w-md">
            <h2 class="text-2xl font-bold text-royal">Selamat datang kembali</h2>
            <p class="mt-1 text-sm text-slate-500">Masuk untuk lanjut ke dashboard.</p>

            <div class="mt-4 rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-xs text-slate-500">
                Prototype: tombol Masuk langsung membuka
                <a href="{{ route('dashboard') }}" class="font-semibold text-royal underline">dashboard</a>.
                Breeze akan dipasang nanti.
            </div>

            <form action="{{ route('dashboard') }}" method="GET" class="mt-6 space-y-4">
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" type="email" placeholder="nama@lab.go.id"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" type="password" placeholder="••••••••"
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 text-slate-600">
                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 accent-[#00D97A]">
                        Ingat saya
                    </label>
                    <span class="text-slate-400">Lupa password?</span>
                </div>
                <button type="submit"
                        class="w-full rounded-xl bg-brand px-4 py-2.5 text-sm font-bold text-royal-dark transition hover:bg-brand-dark active:translate-y-px">
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
