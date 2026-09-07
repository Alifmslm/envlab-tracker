@extends('layouts.app')

@section('title', 'Dashboard - EnvLab Tracker')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan pengujian sampel laboratorium')

@section('content')
@php
    use App\Support\Rupiah;
@endphp

<!-- Summary cards -->
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
    <div class="rounded-lg bg-white p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Jenis Sampel Terdaftar</p>
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand/15 text-emerald-700">
                <x-heroicon-o-beaker class="h-5 w-5" />
            </span>
        </div>
        <p class="mt-3 text-3xl font-bold text-royal">{{ $totalJenisSampelTerdaftar ?? 0 }}</p>
    </div>
    <div class="rounded-lg bg-white p-5">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Titik / Replikasi Diuji</p>
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand/15 text-emerald-700">
                <x-heroicon-o-map-pin class="h-5 w-5" />
            </span>
        </div>
        <p class="mt-3 text-3xl font-bold text-royal">{{ $totalTitikSampel ?? 0 }}</p>
    </div>
    <div class="rounded-lg bg-white p-5 sm:col-span-2 xl:col-span-1">
        <div class="flex items-center justify-between">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Estimasi Nilai Tagihan Uji</p>
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand/15 text-emerald-700">
                <x-heroicon-o-banknotes class="h-5 w-5" />
            </span>
        </div>
        <p class="mt-3 text-3xl font-bold text-royal">{{ Rupiah::format($totalEstimasiTagihan ?? 0) }}</p>
    </div>
</div>

<!-- Recent table -->
<div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-white">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
        <div>
            <h2 class="text-sm font-bold text-royal">Data Sampel Terbaru</h2>
            <p class="text-xs text-slate-500">8 entri terakhir. Kelola penuh di halaman Data Sampel.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('data-sampels.index') }}"
               class="inline-flex items-center gap-1.5 rounded-lg border border-royal/20 px-4 py-2 text-xs font-semibold text-royal transition hover:bg-royal hover:text-white">
                Lihat Semua
                <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
            </a>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('data-sampels.index') }}"
                   class="inline-flex items-center gap-1.5 rounded-lg bg-brand px-4 py-2 text-xs font-bold text-white transition hover:bg-brand-dark">
                    <x-heroicon-o-plus class="h-4 w-4" />
                    Tambah
                </a>
            @endif
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead>
            <tr class="bg-royal text-xs uppercase tracking-wide text-white">
                <th class="px-5 py-3 font-semibold">Kode</th>
                <th class="px-5 py-3 font-semibold">Nama</th>
                <th class="px-5 py-3 font-semibold">Jenis</th>
                <th class="px-5 py-3 font-semibold">Titik</th>
                <th class="px-5 py-3 font-semibold">Status</th>
                <th class="px-5 py-3 text-right font-semibold">Total</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($recentSampels ?? [] as $s)
                <tr class="transition hover:bg-slate-50">
                    <td class="px-5 py-3 font-semibold text-royal">{{ $s->kode_sampel }}</td>
                    <td class="px-5 py-3 text-slate-700">{{ $s->nama_sampel }}</td>
                    <td class="px-5 py-3">
                        <span class="rounded-full bg-royal/10 px-2.5 py-1 text-xs font-medium text-royal">{{ $s->jenis_sampel }}</span>
                    </td>
                    <td class="px-5 py-3 text-slate-700">{{ $s->jumlah_titik }}</td>
                    <td class="px-5 py-3">
                        @if ($s->status_uji === 'Completed')
                            <span class="rounded-full bg-brand/15 px-2.5 py-1 text-xs font-semibold text-emerald-700">Completed</span>
                        @elseif ($s->status_uji === 'In Analysis')
                            <span class="rounded-full bg-royal/10 px-2.5 py-1 text-xs font-semibold text-royal">In Analysis</span>
                        @else
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Pending</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right font-semibold text-slate-800">{{ Rupiah::format($s->jumlah_titik * $s->biaya_per_titik) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center">
                        <p class="font-semibold text-slate-500">Belum ada data sampel.</p>
                        <p class="mt-1 text-xs text-slate-400">Jalankan <code class="rounded bg-slate-100 px-1.5 py-0.5">php artisan db:seed --class=DataSampelSeeder</code> untuk memuat contoh data.</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
