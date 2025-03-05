<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Talent;
use App\Models\GajiTalent;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;

class GajiTalentImport implements ToModel
{
    public function model(array $row)
    {
        // Cari talent berdasarkan nama (asumsikan ada di kolom pertama)
        $talent = Talent::where('nama_talent', $row[0])->first();

        if (!$talent) {
            Log::error("Talent dengan nama '{$row[0]}' tidak ditemukan.");
            return null;
        }

        return new GajiTalent([
            'talent_id' => $talent->id,
            'periode_gaji_awal' => Carbon::createFromFormat('d F Y', $row[1])->format('Y-m-d'),
            'periode_gaji_akhir' => Carbon::createFromFormat('d F Y', $row[2])->format('Y-m-d'),
            'fee_live_perjam' => $this->parseNumber($row[3]),
            'fee_take_video_perjam' => $this->parseNumber($row[4]),
            'total_lama_sesi_live' => $this->parseNumber($row[5]),
            'total_lama_sesi_take_video' => $this->parseNumber($row[6]),
            'fee_live_didapat' => $this->parseNumber($row[7]),
            'fee_take_video_didapat' => $this->parseNumber($row[8]),
            'jumlah_total_omset' => $this->parseNumber($row[9]),
            'rate_omset_perjam' => $this->parseNumber($row[10]),
            'bonus' => $this->parseNumber($row[11]),
            'total_gaji' => $this->parseNumber($row[12]),
        ]);
    }
    private function parseNumber($value)
    {
        // Ubah format "35.000,00" menjadi "35000.00"
        return floatval(str_replace(',', '.', str_replace('.', '', $value)));
    }
}
