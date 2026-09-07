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

            <x-auth-session-status class="mt-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@lab.go.id"
                           class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>
                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password</label>
                    <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••••"
                           class="w-full rounded-lg border border-slate-200 px-4 py-2.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label for="remember_me" class="flex items-center gap-2 text-slate-600">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 accent-[#00D97A]">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-royal hover:underline">Lupa password?</a>
                    @endif
                </div>
                <button type="submit"
                        class="w-full rounded-lg bg-brand px-4 py-2.5 text-sm font-bold text-white transition hover:bg-brand-dark active:translate-y-px">
                    Masuk
                </button>
            </form>

            @if (Route::has('register'))
                <p class="mt-6 text-center text-xs text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-royal hover:underline">Daftar</a>
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
