<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_provinsi'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'kode_provinsi', 'kode');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'kode_kota', 'kode');
    }
} 