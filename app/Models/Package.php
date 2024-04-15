<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Package extends Model
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
        'biro_id',
        'order_number',
    ];

    protected $appends = [
        'thumbnail_path',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('package', function (Builder $builder) {
            $builder->where('type', 'package');
            if(!auth()->user()->hasRole('super_admin')) {
                $builder->where('biro_id', auth()->user()->biro_id);
            }
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
            // $model->excerpt = $model->excerpt ?? substr(strip_tags($model->content), 0, 100);
            $model->type = 'package';
            $model->biro_id = $model->biro_id ?? auth()->user()->biro_id;
            $model->created_by = auth()->user()->id;
        });

        static::updating(function ($model) {
            // $model->excerpt = $model->excerpt ?? substr(strip_tags($model->content), 0, 100);
            $slug = $model->slug ?? Str::slug($model->title);
            $data = self::where('slug', $slug)->where('id', '<>', $model->id)->latest()->first();
            if ($data) {
                $model->slug = $slug . '-' . $data->id + 1;
            }
        });
    }

    public function getThumbnailPathAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : null;
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function biro() {
        return $this->belongsTo(Biro::class, 'biro_id');
    }
}
