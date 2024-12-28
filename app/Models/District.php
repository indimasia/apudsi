<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_kota',
        'kode_provinsi'
    ];

    public function city(): BelongsTo {
        return $this->belongsTo(City::class, 'kode_kota', 'kode');
    }

    public function province(): BelongsTo {
        return $this->belongsTo(Province::class, 'kode_provinsi', 'kode');
    }

    public function villages(): HasMany {
        return $this->hasMany(Village::class, 'kode_kecamatan', 'kode');
    }
} 