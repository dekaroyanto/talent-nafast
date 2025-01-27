<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiTalent extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'total_gaji',
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
