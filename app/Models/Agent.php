<?php

namespace App\Models;

use App\Models\AgentReport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'title',
        'description',
        'image',
    ];

    function createdBy(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    function reports(): HasMany {
        return $this->hasMany(AgentReport::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/'. $value) : null,
        );
    }
}
