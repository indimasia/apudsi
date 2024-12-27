<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_kota'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'kode_kota', 'kode');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'kode_kecamatan', 'kode');
    }
} 