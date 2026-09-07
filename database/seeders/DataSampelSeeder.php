<?php

namespace Database\Seeders;

use App\Models\DataSampel;
use Illuminate\Database\Seeder;

class DataSampelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'kode_sampel' => 'SMP-2026-001',
                'nama_sampel' => 'Air Limbah PT X - Outlet IPAL',
                'jenis_sampel' => 'Air Limbah',
                'jumlah_titik' => 3,
                'biaya_per_titik' => 750000,
                'status_uji' => 'Pending',
                'catatan_kondisi' => 'Botol sampel diterima dingin, suhu 6°C, segel utuh.',
            ],
            [
                'kode_sampel' => 'SMP-2026-002',
                'nama_sampel' => 'Air Bersih PDAM - Reservoir Kota',
                'jenis_sampel' => 'Air Bersih',
                'jumlah_titik' => 5,
                'biaya_per_titik' => 450000,
                'status_uji' => 'In Analysis',
                'catatan_kondisi' => null,
            ],
            [
                'kode_sampel' => 'SMP-2026-003',
                'nama_sampel' => 'Udara Ambien - Kawasan Industri',
                'jenis_sampel' => 'Udara',
                'jumlah_titik' => 2,
                'biaya_per_titik' => 1200000,
                'status_uji' => 'In Analysis',
                'catatan_kondisi' => 'Filter partikulat sedikit lembap saat diterima.',
            ],
            [
                'kode_sampel' => 'SMP-2026-004',
                'nama_sampel' => 'Emisi Gas - Cerobong Boiler PT Y',
                'jenis_sampel' => 'Emisi Gas',
                'jumlah_titik' => 1,
                'biaya_per_titik' => 2500000,
                'status_uji' => 'Pending',
                'catatan_kondisi' => 'Tabung impinger dikirim dalam coolbox.',
            ],
            [
                'kode_sampel' => 'SMP-2026-005',
                'nama_sampel' => 'Tanah - Lahan Bekas Tambang Blok A',
                'jenis_sampel' => 'Tanah',
                'jumlah_titik' => 4,
                'biaya_per_titik' => 600000,
                'status_uji' => 'Completed',
                'catatan_kondisi' => 'Satu kantong kemasan sobek, sampel tetap diuji atas persetujuan klien.',
            ],
            [
                'kode_sampel' => 'SMP-2026-006',
                'nama_sampel' => 'Air Limbah RSUD - Inlet WWTP',
                'jenis_sampel' => 'Air Limbah',
                'jumlah_titik' => 2,
                'biaya_per_titik' => 800000,
                'status_uji' => 'Completed',
                'catatan_kondisi' => null,
            ],
        ];

        foreach ($samples as $sample) {
            DataSampel::updateOrCreate(
                ['kode_sampel' => $sample['kode_sampel']],
                $sample
            );
        }
    }
}
