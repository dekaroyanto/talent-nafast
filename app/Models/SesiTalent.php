<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiTalent extends Model
{
    use HasFactory;

    protected $table = 'sesi_talent';

    protected $fillable = [
        'talent_id',
        'jenis_sesi',
        'tanggal_waktu_mulai',
        'tanggal_waktu_selesai',
        'lama_sesi',
        'total_omset',
        'list_video',
    ];
    protected $casts = [
        'list_video' => 'array',
    ];

    public function talent()
    {
        return $this->belongsTo(Talent::class);
    }
}
