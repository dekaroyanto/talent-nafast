<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{
    protected $guarded = [];

    public function sesiTalent()
    {
        return $this->hasMany(SesiTalent::class);
    }
}
