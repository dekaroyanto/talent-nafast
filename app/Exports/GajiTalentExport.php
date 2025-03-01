<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\GajiTalent;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GajiTalentExport implements FromCollection, WithHeadings, WithMapping
{
    protected $start_date, $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return GajiTalent::with('talent')
            ->whereBetween('periode_gaji_awal', [$this->start_date, $this->end_date])
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Talent',
            'Periode Gaji Awal',
            'Periode Gaji Akhir',
            'Fee Live/Jam',
            'Fee Take Video/Jam',
            'Total Lama Sesi Live',
            'Total Lama Sesi Take Video',
            'Fee Live Didapat',
            'Fee Take Video Didapat',
            'Jumlah Total Omset',
            'Rate Omset per Jam',
            'Bonus',
            'Total Gaji'
        ];
    }

    public function map($gaji): array
    {
        return [
            $gaji->talent->nama_talent,
            Carbon::parse($gaji->periode_gaji_awal)->translatedFormat('d F Y'),
            Carbon::parse($gaji->periode_gaji_akhir)->translatedFormat('d F Y'),
            number_format($gaji->fee_live_perjam, 2, ',', '.'),
            number_format($gaji->fee_take_video_perjam, 2, ',', '.'),
            number_format($gaji->total_lama_sesi_live, 2, ',', '.'),
            number_format($gaji->total_lama_sesi_take_video, 2, ',', '.'),
            number_format($gaji->fee_live_didapat, 2, ',', '.'),
            number_format($gaji->fee_take_video_didapat, 2, ',', '.'),
            number_format($gaji->jumlah_total_omset, 2, ',', '.'),
            number_format($gaji->rate_omset_perjam, 2, ',', '.'),
            number_format($gaji->bonus, 2, ',', '.'),
            number_format($gaji->total_gaji, 2, ',', '.'),
        ];
    }
}
