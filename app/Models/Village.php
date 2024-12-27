<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_kecamatan'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'kode_kecamatan', 'kode');
    }
} 