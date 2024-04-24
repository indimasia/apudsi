<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sos extends Model
{
    use HasFactory;

    protected $fillable = [
        'note',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function getDistanceInKmAttribute() {
        $lat1 = auth()->user()->lat;
        $lon1 = auth()->user()->lng;
        $lat2 = $this->user->lat;
        $lon2 = $this->user->lng;

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $kilometers = $dist * 60 * 1.1515 * 1.609344;

        $kilometers = is_nan($kilometers) ? 0 : $kilometers;

        return round($kilometers, 2);
    }

    function scopeWithoutMe($query) {
        return $query->where('user_id', '!=', auth()->user()->id);
    }
}
