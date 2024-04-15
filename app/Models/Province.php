<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'code',
    ];

    public function biros()
    {
        return $this->hasMany(Biro::class, 'province_code', 'code');
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'province_code', 'parent_code');
    }
}
