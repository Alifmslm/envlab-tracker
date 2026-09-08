<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SampleResource;
use App\Models\DataSampel;

class SampleController extends Controller
{
    public function index()
    {
        $samples = DataSampel::latest()->get();

        return SampleResource::collection($samples);
    }

    public function show(string $kode_sample)
    {
        $sample = DataSampel::where('kode_sampel', $kode_sample)->first();

        if (! $sample) {
            return response()->json(['message' => 'Sample not found'], 404);
        }

        return new SampleResource($sample);
    }
}
