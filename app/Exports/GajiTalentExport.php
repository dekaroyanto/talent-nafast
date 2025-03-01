<?php

namespace App\Exports;

use App\Models\GajiTalent;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class GajiTalentExport implements FromCollection, WithHeadings
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
            ->select(
                'talent_id',
                'periode_gaji_awal',
                'periode_gaji_akhir',
                'fee_live_perjam',
                'fee_take_video_perjam',
                'total_lama_sesi_live',
                'total_lama_sesi_take_video',
                'fee_live_didapat',
                'fee_take_video_didapat',
                'jumlah_total_omset',
                'rate_omset_perjam',
                'bonus',
                'total_gaji'
            )->get();
    }

    public function headings(): array
    {
        return [
            'Talent ID',
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
}
