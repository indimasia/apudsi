<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'content',
        'link',
        'image',
        'status',
        'created_by'
    ];

    protected $appends = [
        'photo_path',
        'image_path'
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
        });
    }

    public function getPhotoPathAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
