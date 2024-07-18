<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileS3
{
    public function uploadS3($file, $path)
    {
        $name = md5(time(). $file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $filePath = 'media/'.$path . '/' . $name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));
        return $filePath;
    }

    public function deleteS3($path): void
    {
        $path = explode('media/', $path);
        Storage::disk('s3')->delete('media/' . $path[1]);
    }
}
