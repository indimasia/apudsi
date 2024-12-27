<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'kode_provinsi',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }
    
    public function biros()
    {
        return $this->hasMany(Biro::class, 'city_code', 'code');
    }
}
