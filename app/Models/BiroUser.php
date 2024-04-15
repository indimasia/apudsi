<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class BiroUser extends Model
{
    use HasFactory;

    protected $table = "users";

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'province_code',
        'city_code',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['photo_path'];

    public static function booted(): void {
        static::addGlobalScope('biro-user', function (Builder $builder) {
            if(!auth()->user()->hasRole('super_admin')) {
                $builder->where('biro_id', auth()->user()->biro_id);
                $builder->whereDoesntHave('roles', function ($query) {
                    $query->whereIn('name', ['super_admin', 'biro']);
                });
            }
        });
    }

    public function getPhotoPathAttribute()
    {
        return !empty($this->photo) ? asset('storage/' . $this->photo) : asset('images/logo-yellow.png');
    }

    public function biro()
    {
        return $this->belongsTo(Biro::class);
    }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'kode');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_code', 'kode');
    }
}
