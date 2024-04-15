<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VisitSaudiArticle extends Model
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
        static::addGlobalScope('visit-saudi', function (Builder $builder) {
            $builder->where('type', 'visit-saudi');
        });

        static::creating(function ($model) {
            // Check duplicate slug
            $slug = $model->slug ?? Str::slug($model->title);
            $data = self::withoutGlobalScopes()
                ->where('slug', $slug)
                ->latest()->first();
            if ($data) {
                $model->slug = $slug . '-' . $data->id + 1;
            }
            $model->excerpt = $model->excerpt ?? substr(strip_tags($model->content), 0, 100);
            $model->type = 'visit-saudi';
            $model->created_by = auth()->user()->id;
        });

        static::updating(function ($model) {
            $model->excerpt = $model->excerpt ?? substr(strip_tags($model->content), 0, 100);
            $slug = $model->slug ?? Str::slug($model->title);
            $count = self::where('slug', $slug)->where('id', '<>', $model->id)->count();
            if ($count > 0) {
                $model->slug = $slug . '-' . $count;
            }
        });

        static::deleting(function ($model) {
            $model->slideshows()->delete();
        });
    }

    public function getThumbnailPathAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function slideshows()
    {
        return $this->hasMany(Slideshow::class, 'post_id');
    }
}
