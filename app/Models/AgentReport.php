<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'lng',
        'lat',
        'image',
        'description',
        'province_code',
        'regency_code',
        'city_code',
        'district_code',
        'village_code',
        'agent_id',
        'created_by',
    ];

    function agent(): BelongsTo {
        return $this->belongsTo(Agent::class);
    }

    function createdBy(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    function province(): BelongsTo {
        return $this->belongsTo(Province::class, 'province_code', 'kode');
    }

    function city(): BelongsTo {
        return $this->belongsTo(City::class, 'city_code', 'kode');
    }

    function district(): BelongsTo {
        return $this->belongsTo(District::class, 'district_code', 'kode');
    }
    
    function village(): BelongsTo {
        return $this->belongsTo(Village::class, 'village_code', 'kode');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/'. $value) : null,
        );
    }
}
