<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSampel extends Model
{
    /** @use HasFactory<\Database\Factories\DataSampelFactory> */
    use HasFactory;

    protected $fillable = [
        'kode_sampel',
        'nama_sampel',
        'jenis_sampel',
        'jumlah_titik',
        'biaya_per_titik',
        'status_uji',
        'catatan_kondisi',
    ];
}
