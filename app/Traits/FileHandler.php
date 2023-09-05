<?php

namespace App\Traits;

trait FileHandler
{
    protected static function bootFileHandler()
    {
        static::creating(function ($model) {
            $model->uploadImages($model);
        });

        static::updating(function ($model) {
            self::deleteOldFiles($model, true);
            $model->uploadImages($model);
        });

        static::deleting(function ($model) {
            self::deleteOldFiles($model);
        });
    }

    public function uploadImages($model)
    {
        if (!isset($this->files) || !is_array($this->files)) {
            return;
        }
        foreach ($this->files as $fieldName) {
            if (request()->hasFile($fieldName)) {
                $file = request()->file($fieldName);
                $file = $this->uploadFile($file, $this->uploadPath($fieldName));
                $model->$fieldName = $file[0];
            }
        }
    }

    protected function hasFile($fieldName)
    {
        return isset($this->attributes[$fieldName]);
    }
}
