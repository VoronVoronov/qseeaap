<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileS3
{
    public function uploadS3($file, $path): string
    {
        $name = time() . '.' . $file->getClientOriginalExtension();
        $filePath = $path . '/' . $name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));
        return $filePath;
    }

    public function deleteS3($path): void
    {
        Storage::disk('s3')->delete($path);
    }
}
