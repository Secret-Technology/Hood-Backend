<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];


    public function setFromAttribute($value)
    {
        $this->attributes['from'] = json_encode($value, true);
    }

    public function setToAttribute($value)
    {
        $this->attributes['to'] = json_encode($value, true);
    }

    public function setExtraRoutesAttribute($value)
    {
        $this->attributes['extra_routes'] = json_encode($value, true);
    }

    public function getExtraRoutesAttribute()
    {
        if (isset($this->attributes['extra_routes'])) {
            $routes = json_decode($this->attributes['extra_routes'], true);
            $new_routes = [];
            if (is_array($routes)) {
                foreach ($routes as $route) {
                    $new_routes[] = ['lat' => (float) @$route['lat'], 'lng' => (float) @$route['lng'], 'location' => (float) @$route['location']];
                }
            }
            return array_reverse($new_routes);
        }
    }

    public function getFromAttribute()
    {
        return json_decode($this->attributes['from'], true);
    }

    public function getToAttribute()
    {
        return json_decode($this->attributes['to'], true);
    }
}
