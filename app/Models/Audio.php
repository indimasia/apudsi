<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = "post_audios";

    protected $fillable = [
        'title',
        'image',
        'audio',
        'caption',
        'order_number',
    ];

    protected $appends = [
        'image_path',
        'audio_path',
    ];

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getAudioPathAttribute()
    {
        return $this->audio ? asset('storage/' . $this->audio) : null;
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
