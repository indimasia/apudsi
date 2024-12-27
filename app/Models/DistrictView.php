<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistrictView extends Model
{
    protected $table = 'wilayah_districts_view';
    
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'kode_kota'
    ];
} 