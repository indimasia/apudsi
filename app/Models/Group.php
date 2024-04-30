<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "image",
        "note",
        'created_by'
    ];

    protected $appends = [
        'image_path',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
            $model->last_activity = now();
        });

        static::created(function ($model) {
            $model->members()->attach(auth()->user()->id, ['is_admin' => true]);
        });

        static::deleting(function ($model) {
            // $model->chats()->delete();
            $model->members()->detach();
        });
    }

    public function getImagePathAttribute()
    {
        return !empty($this->image) ? asset('storage/' . $this->image) : "";
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id')
            ->withPivot('is_admin');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'group_id');
    }
}
