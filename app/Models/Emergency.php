<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Emergency extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'thumbnail',
        'title',
        'excerpt',
        'content',
        'slug',
        'status',
        'type',
        'order_number',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('emergency', function (Builder $builder) {
            $builder->where('type', 'emergency');
        });

        static::creating(function ($model) {
            // Check duplicate slug
            $model->type = 'emergency';
            $model->created_by = auth()->user()->id;
        });
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
