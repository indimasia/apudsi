<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama'
    ];

    public function cities(): HasMany {
        return $this->hasMany(City::class, 'kode_provinsi', 'kode');
    }
} 