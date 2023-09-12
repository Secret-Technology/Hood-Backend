<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        if (isset($this->attributes['status_times']) && $this->attributes['status_times']) {
            $statuses = [];
            $old_statuses = json_decode($this->attributes['status_times'], true) ?? [];
            $status = [[$value => Carbon::now()->format('Y-m-d H:i:s')]];
            $statuses = array_merge($old_statuses, $status);
            $this->attributes['status_times'] = json_encode($statuses);
        } else {
            $this->attributes['status_times'] = json_encode([[$value => Carbon::now()->format('Y-m-d H:i:s')]]);
        }
    }

    public function getStatusTimesAttribute()
    {
        return $this->attributes['status_times'] ? json_decode($this->attributes['status_times'], true) : [];
    }

    public function setGoogleRouteAttribute($value)
    {
        $this->attributes['google_route'] = json_encode($value, true);
    }

    public function getGoogleRouteAttribute()
    {
        return json_decode($this->attributes['google_route'], true);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function address()
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id');
    }

    public function details()
    {
        return $this->hasOne(ParcelOrderDetail::class, 'order_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
}
