<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class GajiTalentTemplate implements FromArray
{
    public function array(): array
    {
        return [
            // Header Kolom
            ['Nama Talent', 'Periode Awal', 'Periode Akhir', 'Fee Live/Jam', 'Fee Take Video/Jam', 'Total Sesi Live', 'Total Sesi Take Video', 'Fee Live Didapat', 'Fee Take Video Didapat', 'Jumlah Omset', 'Rate Omset/Jam', 'Bonus', 'Total Gaji'],

            // Contoh Data
            ['Deka Ganteng', '01 Januari 2025', '31 Januari 2025', 50000, 40000, 10, 5, 500000, 200000, 1500000, 150000, 100000, 800000],
        ];
    }
}
