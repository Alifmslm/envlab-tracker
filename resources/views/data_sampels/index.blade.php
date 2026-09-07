@extends('layouts.app')

@section('title', 'Data Sampel - EnvLab Tracker')
@section('page-title', 'Data Sampel')
@section('page-subtitle', 'Kelola data sampel. Semua aksi tambah, lihat, ubah, hapus memakai modal.')

@section('content')
@php
    use App\Support\Rupiah;
    $jenisOptions = ['Air Bersih', 'Air Limbah', 'Udara', 'Emisi Gas', 'Tanah'];
    $statusOptions = ['Pending', 'In Analysis', 'Completed'];
    $failedEditId = old('_edit_id');
@endphp

<!-- Mini summary strip -->
<div class="grid gap-4 sm:grid-cols-3">
    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Jenis Terdaftar</p>
        <p class="mt-1 text-2xl font-bold text-royal">{{ $totalJenisSampelTerdaftar ?? 0 }}</p>
    </div>
    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Total Titik</p>
        <p class="mt-1 text-2xl font-bold text-royal">{{ $totalTitikSampel ?? 0 }}</p>
    </div>
    <div class="rounded-2xl bg-white p-4 shadow-sm">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Estimasi Tagihan</p>
        <p class="mt-1 text-2xl font-bold text-royal">{{ Rupiah::format($totalEstimasiTagihan ?? 0) }}</p>
    </div>
</div>

<!-- Table card -->
<div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
        <div>
            <h2 class="text-sm font-bold text-royal">Tabel Data Sampel</h2>
            <p class="text-xs text-slate-500">Klik Lihat, Ubah, atau Hapus pada baris. Tidak ada halaman terpisah.</p>
        </div>
        <button type="button" data-open-modal="modal-create"
                class="rounded-xl bg-brand px-4 py-2 text-xs font-bold text-royal-dark transition hover:bg-brand-dark active:translate-y-px">
            + Tambah Sampel
        </button>
    </div>

    @if ($errors->any())
        <div class="mx-5 mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs text-red-700">
            <p class="font-bold">Periksa kembali isian:</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
            <thead>
            <tr class="bg-royal text-xs uppercase tracking-wide text-white">
                <th class="px-5 py-3 font-semibold">Kode</th>
                <th class="px-5 py-3 font-semibold">Nama</th>
                <th class="px-5 py-3 font-semibold">Jenis</th>
                <th class="px-5 py-3 font-semibold">Titik</th>
                <th class="px-5 py-3 font-semibold">Biaya/Titik</th>
                <th class="px-5 py-3 font-semibold">Status</th>
                <th class="px-5 py-3 text-right font-semibold">Total</th>
                <th class="px-5 py-3 text-right font-semibold">Aksi</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
            @forelse ($dataSampels as $s)
                <tr class="transition hover:bg-slate-50">
                    <td class="px-5 py-3 font-semibold text-royal">{{ $s->kode_sampel }}</td>
                    <td class="px-5 py-3 text-slate-700">{{ $s->nama_sampel }}</td>
                    <td class="px-5 py-3">
                        <span class="rounded-full bg-royal/10 px-2.5 py-1 text-xs font-medium text-royal">{{ $s->jenis_sampel }}</span>
                    </td>
                    <td class="px-5 py-3 text-slate-700">{{ $s->jumlah_titik }}</td>
                    <td class="px-5 py-3 text-slate-700">{{ Rupiah::format($s->biaya_per_titik) }}</td>
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
                    <td class="px-5 py-3">
                        <div class="flex justify-end gap-1.5">
                            <button type="button"
                                    data-open-modal="modal-show"
                                    data-id="{{ $s->id }}"
                                    data-kode="{{ $s->kode_sampel }}"
                                    data-nama="{{ $s->nama_sampel }}"
                                    data-jenis="{{ $s->jenis_sampel }}"
                                    data-titik="{{ $s->jumlah_titik }}"
                                    data-biaya="{{ $s->biaya_per_titik }}"
                                    data-total="{{ Rupiah::format($s->jumlah_titik * $s->biaya_per_titik) }}"
                                    data-status="{{ $s->status_uji }}"
                                    data-catatan="{{ $s->catatan_kondisi ?? '-' }}"
                                    class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-semibold text-slate-600 transition hover:border-royal hover:text-royal">
                                Lihat
                            </button>
                            <button type="button"
                                    data-open-modal="modal-edit"
                                    data-id="{{ $s->id }}"
                                    data-kode="{{ $s->kode_sampel }}"
                                    data-nama="{{ $s->nama_sampel }}"
                                    data-jenis="{{ $s->jenis_sampel }}"
                                    data-titik="{{ $s->jumlah_titik }}"
                                    data-biaya="{{ $s->biaya_per_titik }}"
                                    data-status="{{ $s->status_uji }}"
                                    data-catatan="{{ $s->catatan_kondisi }}"
                                    class="rounded-lg bg-royal px-2.5 py-1.5 text-xs font-semibold text-white transition hover:bg-royal-dark">
                                Ubah
                            </button>
                            <button type="button"
                                    data-open-modal="modal-delete"
                                    data-id="{{ $s->id }}"
                                    data-kode="{{ $s->kode_sampel }}"
                                    data-nama="{{ $s->nama_sampel }}"
                                    class="rounded-lg border border-red-200 px-2.5 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-600 hover:text-white">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center">
                        <p class="font-semibold text-slate-500">Belum ada data sampel.</p>
                        <p class="mt-1 text-xs text-slate-400">Klik Tambah Sampel atau jalankan <code class="rounded bg-slate-100 px-1.5 py-0.5">php artisan db:seed --class=DataSampelSeeder</code>.</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if ($dataSampels instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="border-t border-slate-100 px-5 py-4">
            {{ $dataSampels->links() }}
        </div>
    @endif
</div>

<!-- ============ MODAL: CREATE ============ -->
<div id="modal-create" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-xl">
        <div class="flex items-center justify-between bg-royal px-6 py-4 text-white">
            <h3 class="text-sm font-bold">Tambah Sampel Baru</h3>
            <button type="button" data-close-modal class="rounded-lg px-2 py-1 text-lg leading-none hover:bg-white/15">×</button>
        </div>
        <form action="{{ route('data-sampels.store') }}" method="POST" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
            @csrf
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Kode Sampel *</label>
                <input name="kode_sampel" value="{{ old('kode_sampel') }}" required placeholder="SMP-2026-007"
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                @error('kode_sampel')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Nama Sampel *</label>
                <input name="nama_sampel" value="{{ old('nama_sampel') }}" required placeholder="Air Limbah PT Z - Outlet"
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                @error('nama_sampel')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Jenis Sampel *</label>
                <select name="jenis_sampel" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                    <option value="">Pilih jenis</option>
                    @foreach ($jenisOptions as $j)
                        <option value="{{ $j }}" @selected(old('jenis_sampel') === $j)>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jenis_sampel')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Status Uji *</label>
                <select name="status_uji" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                    <option value="">Pilih status</option>
                    @foreach ($statusOptions as $st)
                        <option value="{{ $st }}" @selected(old('status_uji') === $st)>{{ $st }}</option>
                    @endforeach
                </select>
                @error('status_uji')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Jumlah Titik *</label>
                <input name="jumlah_titik" type="number" min="0" step="1" value="{{ old('jumlah_titik', 1) }}" required
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                @error('jumlah_titik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Biaya per Titik (Rp) *</label>
                <input name="biaya_per_titik" type="number" min="0" step="1" value="{{ old('biaya_per_titik', 0) }}" required
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                @error('biaya_per_titik')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Catatan Kondisi <span class="font-normal text-slate-400">(opsional)</span></label>
                <textarea name="catatan_kondisi" rows="2" placeholder="Kondisi sampel saat diterima..."
                          class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">{{ old('catatan_kondisi') }}</textarea>
                @error('catatan_kondisi')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex justify-end gap-2 sm:col-span-2">
                <button type="button" data-close-modal class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="rounded-xl bg-brand px-5 py-2 text-xs font-bold text-royal-dark transition hover:bg-brand-dark active:translate-y-px">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ============ MODAL: EDIT ============ -->
<div id="modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-xl">
        <div class="flex items-center justify-between bg-royal px-6 py-4 text-white">
            <h3 class="text-sm font-bold">Ubah Sampel <span id="edit-title-kode" class="font-normal text-white/70"></span></h3>
            <button type="button" data-close-modal class="rounded-lg px-2 py-1 text-lg leading-none hover:bg-white/15">×</button>
        </div>
        <form id="edit-form" method="POST" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
            @csrf
            @method('PUT')
            <input type="hidden" name="_edit_id" id="edit-id-field" value="{{ $failedEditId }}">
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Kode Sampel *</label>
                <input id="edit-kode" name="kode_sampel" required
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Nama Sampel *</label>
                <input id="edit-nama" name="nama_sampel" required
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Jenis Sampel *</label>
                <select id="edit-jenis" name="jenis_sampel" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                    @foreach ($jenisOptions as $j)
                        <option value="{{ $j }}">{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Status Uji *</label>
                <select id="edit-status" name="status_uji" required
                        class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
                    @foreach ($statusOptions as $st)
                        <option value="{{ $st }}">{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Jumlah Titik *</label>
                <input id="edit-titik" name="jumlah_titik" type="number" min="0" step="1" required
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Biaya per Titik (Rp) *</label>
                <input id="edit-biaya" name="biaya_per_titik" type="number" min="0" step="1" required
                       class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
            </div>
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold text-slate-700">Catatan Kondisi <span class="font-normal text-slate-400">(opsional)</span></label>
                <textarea id="edit-catatan" name="catatan_kondisi" rows="2"
                          class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/30"></textarea>
            </div>
            <div class="flex justify-end gap-2 sm:col-span-2">
                <button type="button" data-close-modal class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="rounded-xl bg-brand px-5 py-2 text-xs font-bold text-royal-dark transition hover:bg-brand-dark active:translate-y-px">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- ============ MODAL: SHOW ============ -->
<div id="modal-show" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-xl">
        <div class="flex items-center justify-between bg-royal px-6 py-4 text-white">
            <h3 class="text-sm font-bold">Detail Sampel</h3>
            <button type="button" data-close-modal class="rounded-lg px-2 py-1 text-lg leading-none hover:bg-white/15">×</button>
        </div>
        <div class="space-y-4 px-6 py-5 text-sm">
            <div class="flex flex-wrap items-center gap-2">
                <span id="show-kode" class="rounded-lg bg-royal px-3 py-1 font-bold text-white"></span>
                <span id="show-status" class="rounded-full px-2.5 py-1 text-xs font-semibold"></span>
                <span id="show-jenis" class="rounded-full bg-royal/10 px-2.5 py-1 text-xs font-medium text-royal"></span>
            </div>
            <p id="show-nama" class="text-base font-semibold text-slate-800"></p>
            <div class="grid grid-cols-3 gap-3">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-[11px] text-slate-500">Titik</p>
                    <p id="show-titik" class="text-lg font-bold text-royal"></p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-[11px] text-slate-500">Biaya/Titik</p>
                    <p id="show-biaya" class="text-lg font-bold text-royal"></p>
                </div>
                <div class="rounded-xl bg-brand/10 p-3">
                    <p class="text-[11px] text-slate-500">Total</p>
                    <p id="show-total" class="text-lg font-bold text-emerald-700"></p>
                </div>
            </div>
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Catatan Kondisi</p>
                <p id="show-catatan" class="mt-1 rounded-xl bg-slate-50 p-3 text-slate-700"></p>
            </div>
            <div class="flex justify-end">
                <button type="button" data-close-modal class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- ============ MODAL: DELETE ============ -->
<div id="modal-delete" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm">
    <div class="w-full max-w-sm overflow-hidden rounded-2xl bg-white shadow-xl">
        <div class="px-6 py-5">
            <h3 class="text-sm font-bold text-slate-800">Hapus sampel ini?</h3>
            <p class="mt-2 text-sm text-slate-600"><span id="delete-kode" class="font-bold text-royal"></span> <span id="delete-nama" class="text-slate-500"></span></p>
            <p class="mt-1 text-xs text-slate-400">Data yang dihapus tidak bisa dikembalikan.</p>
            <form id="delete-form" method="POST" class="mt-4 flex justify-end gap-2">
                @csrf
                @method('DELETE')
                <button type="button" data-close-modal class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50">Batal</button>
                <button type="submit" class="rounded-xl bg-red-600 px-4 py-2 text-xs font-bold text-white transition hover:bg-red-700 active:translate-y-px">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const storeBase = @json(route('data-sampels.store'));
    const updateUrl = id => storeBase + '/' + id;

    function openModal(id) {
        const el = document.getElementById(id);
        if (el) { el.classList.remove('hidden'); el.classList.add('flex'); }
    }
    function closeModal(el) {
        el.classList.add('hidden'); el.classList.remove('flex');
    }
    document.querySelectorAll('[data-open-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-open-modal');
            if (target === 'modal-edit') {
                document.getElementById('edit-form').action = updateUrl(btn.dataset.id);
                document.getElementById('edit-id-field').value = btn.dataset.id;
                document.getElementById('edit-title-kode').textContent = btn.dataset.kode || '';
                document.getElementById('edit-kode').value = btn.dataset.kode || '';
                document.getElementById('edit-nama').value = btn.dataset.nama || '';
                document.getElementById('edit-jenis').value = btn.dataset.jenis || '';
                document.getElementById('edit-status').value = btn.dataset.status || '';
                document.getElementById('edit-titik').value = btn.dataset.titik ?? '';
                document.getElementById('edit-biaya').value = btn.dataset.biaya ?? '';
                document.getElementById('edit-catatan').value = btn.dataset.catatan || '';
            }
            if (target === 'modal-show') {
                document.getElementById('show-kode').textContent = btn.dataset.kode || '';
                document.getElementById('show-nama').textContent = btn.dataset.nama || '';
                document.getElementById('show-jenis').textContent = btn.dataset.jenis || '';
                document.getElementById('show-titik').textContent = btn.dataset.titik || '';
                document.getElementById('show-biaya').textContent = btn.dataset.biaya || '';
                document.getElementById('show-total').textContent = btn.dataset.total || '';
                document.getElementById('show-catatan').textContent = btn.dataset.catatan || '-';
                const badge = document.getElementById('show-status');
                badge.textContent = btn.dataset.status || '';
                badge.className = 'rounded-full px-2.5 py-1 text-xs font-semibold ' +
                    (btn.dataset.status === 'Completed' ? 'bg-brand/15 text-emerald-700'
                    : btn.dataset.status === 'In Analysis' ? 'bg-royal/10 text-royal'
                    : 'bg-amber-100 text-amber-700');
            }
            if (target === 'modal-delete') {
                document.getElementById('delete-form').action = updateUrl(btn.dataset.id);
                document.getElementById('delete-kode').textContent = btn.dataset.kode || '';
                document.getElementById('delete-nama').textContent = ' - ' + (btn.dataset.nama || '');
            }
            openModal(target);
        });
    });
    document.querySelectorAll('[data-close-modal]').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.fixed')));
    });
    document.querySelectorAll('.fixed[id^="modal-"]').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) closeModal(m); });
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') document.querySelectorAll('.fixed[id^="modal-"]').forEach(closeModal);
    });

    @if ($errors->any())
        @if ($failedEditId)
            (function () {
                const row = document.querySelector('[data-open-modal="modal-edit"][data-id="{{ $failedEditId }}"]');
                document.getElementById('edit-form').action = updateUrl('{{ $failedEditId }}');
                document.getElementById('edit-id-field').value = '{{ $failedEditId }}';
                document.getElementById('edit-kode').value = @json(old('kode_sampel', ''));
                document.getElementById('edit-nama').value = @json(old('nama_sampel', ''));
                document.getElementById('edit-jenis').value = @json(old('jenis_sampel', ''));
                document.getElementById('edit-status').value = @json(old('status_uji', ''));
                document.getElementById('edit-titik').value = @json(old('jumlah_titik', ''));
                document.getElementById('edit-biaya').value = @json(old('biaya_per_titik', ''));
                document.getElementById('edit-catatan').value = @json(old('catatan_kondisi', ''));
                if (row) document.getElementById('edit-title-kode').textContent = row.dataset.kode || '';
                openModal('modal-edit');
            })();
        @else
            openModal('modal-create');
        @endif
    @endif
})();
</script>
@endpush
