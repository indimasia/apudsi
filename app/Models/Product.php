<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getImageAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }
}
