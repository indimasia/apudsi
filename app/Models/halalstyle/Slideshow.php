<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    protected $table = "post_slideshows";

    protected $fillable = [
        'title',
        'attachment',
        'caption',
        'order_number',
    ];

    protected $appends = [
        'attachment_path',
    ];

    public function getAttachmentPathAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
