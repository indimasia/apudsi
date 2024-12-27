<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

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

    public function getThumbnailPathAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slideshows()
    {
        return $this->hasMany(Slideshow::class);
    }

    public function audios()
    {
        return $this->hasMany(Audio::class);
    }
}
