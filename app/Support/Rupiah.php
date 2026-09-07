<?php

namespace App\Support;

class Rupiah
{
    /**
     * Format integer amount to Indonesian Rupiah, e.g. 12450000 => "Rp 12.450.000".
     */
    public static function format(int|string|null $amount, string $prefix = 'Rp '): string
    {
        $amount = (int) ($amount ?? 0);

        return $prefix.number_format($amount, 0, ',', '.');
    }
}
