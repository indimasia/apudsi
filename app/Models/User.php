<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\Passwords\CanResetPassword as PasswordsCanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements CanResetPassword, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, PasswordsCanResetPassword, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'biro_id',
        'province_code',
        'city_code',
        'is_active',
        'photo',
        'is_demo',
        'spph',
        'lat',
        'lng',
        'last_online',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_demo' => 'boolean',
    ];

    protected $appends = ['photo_path'];

    public function getPhotoPathAttribute()
    {
        return !empty($this->photo) ? asset('storage/' . $this->photo) : asset('images/logo-yellow.png');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
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
