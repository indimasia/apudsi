<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_kecamatan',
        'kode_kota',
        'kode_provinsi'
    ];

    public function district(): BelongsTo {
        return $this->belongsTo(District::class, 'kode_kecamatan', 'kode');
    }

    public function city(): BelongsTo {
        return $this->belongsTo(City::class, 'kode_kota', 'kode');
    }

    public function province(): BelongsTo {
        return $this->belongsTo(Province::class, 'kode_provinsi', 'kode');
    }
} 
