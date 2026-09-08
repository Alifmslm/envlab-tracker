<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\DataSampel
 */
class SampleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'kode_sampel' => $this->kode_sampel,
            'nama_sampel' => $this->nama_sampel,
            'jenis_sampel' => $this->jenis_sampel,
            'jumlah_titik' => (int) $this->jumlah_titik,
            'biaya_per_titik' => (int) $this->biaya_per_titik,
            'total_biaya' => (int) $this->jumlah_titik * (int) $this->biaya_per_titik,
            'status_uji' => $this->status_uji,
            'catatan_kondisi' => $this->catatan_kondisi,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
