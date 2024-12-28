<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'address',
        'logo',
        'user_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    
    protected function logo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/'. $value) : null,
        );
    }
} 