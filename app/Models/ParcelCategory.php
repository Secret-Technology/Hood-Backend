<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\FileHandler;
use App\Traits\UploadFiles;
use App\Traits\HasActive;

class ParcelCategory extends Model
{
    use HasFactory,
        HasTranslations,
        UploadFiles,
        HasActive,
        FileHandler;

    protected array $translatable = ['name'];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];


    /**
     * The attributes that have files that should be auto deleted on updating or deleting.
     *
     * @var array
     */
    public $files = [
        'img',
    ];

    function uploadPath($type)
    {
        return config("base.parcel_category.uploads.$type.path");
    }

    public function getImgAttribute($value)
    {
        if (!$value) {
            $default_image_path = config('base.parcel_category.uploads.img.default');
            return asset("/$default_image_path");
        }
        return asset('storage/files/' . $this->uploadPath('img') . $value);
    }
}
