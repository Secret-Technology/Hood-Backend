<?php

namespace App\Traits;

use Storage;

trait UploadFiles
{
    public function uploadImage($files, $url = 'temporary', $disk = 'public', $width = null, $height = null)
    {
        $destinationPath = storage_path("app/public/files/{$url}");

        if ($url !== 'images' && !\File::isDirectory($destinationPath)) {
            \File::makeDirectory($destinationPath, 0777, true);
        }

        if (is_array($files)) {
            $uploadedFiles = [];

            foreach ($files as $file) {
                $uploadedFileName = $this->generateUniqueFileName($file);
                $file->move($destinationPath, $uploadedFileName);
                $uploadedFiles[] = $uploadedFileName;
            }

            return $uploadedFiles;
        } else {
            $uploadedFileName = $this->generateUniqueFileName($files);
            $files->move($destinationPath, $uploadedFileName);
            return $uploadedFileName;
        }
    }

    public function uploadFile($files, $url = 'temporary', $disk = 'public', $width = null, $height = null)
    {
        $destinationPath = storage_path("app/public/files/{$url}");

        if ($url !== 'images' && !\File::isDirectory($destinationPath)) {
            \File::makeDirectory($destinationPath, 0777, true);
        }

        $uploadedFiles = [];

        if (is_array($files)) {
            foreach ($files as $file) {
                $uploadedFileName = $this->generateUniqueFileName($file);
                $file->move($destinationPath, $uploadedFileName);
                $uploadedFiles[] = $uploadedFileName;
            }
        } else {
            $uploadedFileName = $this->generateUniqueFileName($files);
            $files->move($destinationPath, $uploadedFileName);
            $uploadedFiles[] = $uploadedFileName;
        }

        return $uploadedFiles;
    }

    private function generateUniqueFileName($file)
    {
        $originalFileName = str_replace(' ', '_', $file->getClientOriginalName());
        $extension = $file->extension();
        $onlyName = explode('.' . $extension, $originalFileName);
        $uniquePart = time();
        return "{$onlyName[0]}_hood_{$uniquePart}_@2023.{$extension}";
    }

    protected static function deleteOldFiles($model, $updating = false)
    {
        $attributes = $model->deletableFiles ?? [];

        if (
            empty($attributes)
            || !method_exists($model, 'uploadPath')
            || is_null($uploadPath = $model->uploadPath())
        ) {
            return;
        }

        $filesToDelete = array_map(function ($attribute) use ($model, $uploadPath, $updating) {
            if (($updating && !$model->isDirty($attribute)) || is_null($value = $model->getOriginal($attribute))) {
                return null;
            }

            return file_path($uploadPath, $value);
        }, $attributes);

        Storage::delete(array_filter($filesToDelete));
    }
}
