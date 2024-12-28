<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_provinsi'
    ];

    public function province(): BelongsTo {
        return $this->belongsTo(Province::class, 'kode_provinsi', 'kode');
    }

    public function districts(): HasMany {
        return $this->hasMany(District::class, 'kode_kota', 'kode');
    }
} 