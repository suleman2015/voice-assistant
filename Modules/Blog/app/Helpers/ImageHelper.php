<?php

namespace Modules\Blog\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class ImageHelper
{
    public static function upload(UploadedFile $image, string $folder): string
    {
        $fileName = 'post_' . now()->format('Ymd_His') . '_' . substr(md5(uniqid()), 0, 8) . '.' . $image->getClientOriginalExtension();
        $destination = public_path($folder);

        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $image->move($destination, $fileName);

        return $fileName;
    }

    public static function delete(?string $imageName, string $folder): void
    {
        if (!$imageName) return;

        $fullPath = public_path($folder . '/' . $imageName);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
