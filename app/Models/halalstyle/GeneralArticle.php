<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GeneralArticle extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'thumbnail',
        'title',
        'slug',
        'content',
        'excerpt',
        'status',
        'type',
        'created_by',
    ];

    protected $appends = [
        'thumbnail_path',
    ];

    public static function booted(): void {
        static::addGlobalScope('general', function (Builder $builder) {
            $builder->where('type', 'general');
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
            $model->type = 'general';
            $model->created_by = auth()->user()->id;
        });

        static::updating(function ($model) {
            $model->excerpt = $model->excerpt ?? substr(strip_tags($model->content), 0, 100);
            $slug = $model->slug ?? Str::slug($model->title);
            $data = self::where('slug', $slug)->where('id', '<>', $model->id)->latest()->first();
            if ($data) {
                $model->slug = $slug . '-' . $data->id + 1;
            }
        });
    }

    public function getThumbnailPathAttribute($value)
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }
    
    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query) {
        return $query->where('status', 'published');
    }
}
