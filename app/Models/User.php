<?php

namespace App\Models;

use App\Traits\FileHandler;
use App\Traits\HasActive;
use App\Traits\AutoSetIP;
use App\Traits\UploadFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasActive,
        UploadFiles,
        FileHandler;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_confirmation_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The attributes that have files that should be auto deleted on updating or deleting.
     *
     * @var array
     */
    public $files = [
        'img',
        'file1',
        'file2'
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name']  = $value;
        $this->attributes['username'] = $value . substr((string) Str::uuid(), 0, 5);
    }

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

    function uploadPath($type)
    {
        return config("base.user.uploads.$type.path");
    }

    public function getImgAttribute($value)
    {
        if (!$value) {
            $default_image_path = config('base.user.uploads.img.default');
            return asset("/$default_image_path");
        }
        return asset('storage/files/' . $this->uploadPath('img') . $value);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
}
