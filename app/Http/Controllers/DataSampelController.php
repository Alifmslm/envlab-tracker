<?php

namespace App\Http\Controllers;

use App\Models\DataSampel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataSampelController extends Controller
{
    public function index(Request $request)
    {
        $dataSampels = DataSampel::latest()->paginate(10);

        $summary = $this->getDashboardSummary();

        if ($request->expectsJson()) {
            return response()->json(array_merge($summary, [
                'data' => $dataSampels,
            ]));
        }

        return view('data_sampels.index', array_merge(compact('dataSampels'), $summary));
    }

    public function dashboard(Request $request)
    {
        $summary = $this->getDashboardSummary();
        $recentSampels = DataSampel::latest()->take(8)->get();

        if ($request->expectsJson()) {
            return response()->json(array_merge($summary, [
                'recent' => $recentSampels,
            ]));
        }

        return view('dashboard', array_merge($summary, compact('recentSampels')));
    }

    /**
     * Get dashboard summary values.
     *
     * @return array{totalJenisSampelTerdaftar: int, totalTitikSampel: int, totalEstimasiTagihan: int}
     */
    protected function getDashboardSummary(): array
    {
        $totalJenisSampelTerdaftar = (int) DataSampel::distinct()->count('jenis_sampel');

        $totalTitikSampel = (int) DataSampel::sum('jumlah_titik');

        $totalEstimasiTagihan = (int) (DataSampel::selectRaw('SUM(jumlah_titik * biaya_per_titik) as total')->value('total') ?? 0);

        return compact('totalJenisSampelTerdaftar', 'totalTitikSampel', 'totalEstimasiTagihan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data_sampels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_sampel' => ['required', 'string', 'max:255', 'unique:data_sampels,kode_sampel'],
            'nama_sampel' => ['required', 'string', 'max:255'],
            'jenis_sampel' => ['required', Rule::in(['Air Bersih', 'Air Limbah', 'Udara', 'Emisi Gas', 'Tanah'])],
            'jumlah_titik' => ['required', 'integer', 'min:0'],
            'biaya_per_titik' => ['required', 'integer', 'min:0'],
            'status_uji' => ['required', Rule::in(['Pending', 'In Analysis', 'Completed'])],
            'catatan_kondisi' => ['nullable', 'string'],
        ]);

        $dataSampel = DataSampel::create($validated);

        if ($request->expectsJson()) {
            return response()->json($dataSampel, 201);
        }

        return redirect()
            ->route('data-sampels.index')
            ->with('success', 'Data sampel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, DataSampel $dataSampel)
    {
        if ($request->expectsJson()) {
            return response()->json($dataSampel);
        }

        return view('data_sampels.show', compact('dataSampel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataSampel $dataSampel)
    {
        return view('data_sampels.edit', compact('dataSampel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataSampel $dataSampel)
    {
        if ($request->user()->isStaff()) {
            $validated = $request->validate([
                'status_uji' => ['required', Rule::in(['Pending', 'In Analysis', 'Completed'])],
                'catatan_kondisi' => ['nullable', 'string'],
            ]);
        } else {
            $validated = $request->validate([
                'kode_sampel' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('data_sampels', 'kode_sampel')->ignore($dataSampel->id),
                ],
                'nama_sampel' => ['required', 'string', 'max:255'],
                'jenis_sampel' => ['required', Rule::in(['Air Bersih', 'Air Limbah', 'Udara', 'Emisi Gas', 'Tanah'])],
                'jumlah_titik' => ['required', 'integer', 'min:0'],
                'biaya_per_titik' => ['required', 'integer', 'min:0'],
                'status_uji' => ['required', Rule::in(['Pending', 'In Analysis', 'Completed'])],
                'catatan_kondisi' => ['nullable', 'string'],
            ]);
        }

        $dataSampel->update($validated);

        if ($request->expectsJson()) {
            return response()->json($dataSampel);
        }

        return redirect()
            ->route('data-sampels.index')
            ->with('success', 'Data sampel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DataSampel $dataSampel)
    {
        $dataSampel->delete();

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()
            ->route('data-sampels.index')
            ->with('success', 'Data sampel berhasil dihapus.');
    }
}
