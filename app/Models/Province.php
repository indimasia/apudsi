<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama'
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'kode_provinsi', 'kode');
    }
} 