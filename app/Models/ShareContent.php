<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ShareContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'link',
        'caption',
        'created_at',
        'updated_at',
        'status',
        'share_counter',
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/'. $value) : null,
        );
    }

    protected static function booted()
    {
        static::creating(function ($shareContent) {
            $shareContent->user_id = auth()->id();
        });
    }

}
