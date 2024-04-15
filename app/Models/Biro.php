<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Biro extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'owner',
        'marketing_phone',
        'logo',
        'province_code',
        'city_code',
        'address',
        'average_person_per_year',
    ];

    protected $appends = ['logo_path'];

    public function getLogoPathAttribute()
    {
        return asset('storage/' . $this->logo);
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'kode');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code', 'kode');
    }
    
    function admin()
    {
        return $this->hasOne(User::class)->whereHas("roles", function($q){ $q->where("name", "biro"); });
    }

    function users()
    {
        return $this->hasMany(User::class)->whereHas("roles", function($q){ $q->where("name", "user"); });
    }

    function allUsers()
    {
        return $this->hasMany(User::class);
    }
}
