<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageView extends Model
{
    protected $table = 'wilayah_villages_view';
    
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_kecamatan'
    ];
} 