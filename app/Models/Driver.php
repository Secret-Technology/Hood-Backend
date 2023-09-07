<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;
use App\Traits\HasActive;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;

class Driver extends Authenticatable implements JWTSubject
{
    use HasFactory,
        HasActive,
        Notifiable,
        HasApiTokens;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeNearest($query, $lat, $lng)
    {
        $lat = (float) $lat;
        $lng = (float) $lng;
        $space_search_by_kilos = (float) 2000;
        $query->select(DB::raw("*,
                (6371 * ACOS(COS(RADIANS($lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($lng) - RADIANS(lng))
                + SIN(RADIANS($lat))
                * SIN(RADIANS(lat)))) AS distance"))
            ->having('distance', '<=', $space_search_by_kilos)
            ->orderBy('distance', 'asc');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'driver_id', 'id');
    }
}
