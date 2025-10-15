<?php

namespace Modules\PageBuilder\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait FileManageTrait
{
    protected $maxSize = 5 * 1024 * 1024; // 5MB

    protected $allowedImageExtensions = ['jpeg', 'png', 'jpg', 'gif', 'svg', 'webp', 'avif'];
    protected $allowedFileExtensions = [
        'zip',
        'rar',
        'pdf',
        'doc',
        'docx',
        'txt',
        'csv',
        'xml',
        'json',
        'ppt',
        'pptx',
        'ods',
        'odt',
        'xls',
        'xlsx',
        'png',
        'jpg',
        'gif',
        'svg',
        'webp',
        'avif'
    ];

    public function uploadImage($file, $old = null): ?string
    {
        if (!$file->isValid()) {
            abort(406, 'Invalid image file.');
        }

        $ext = strtolower($file->getClientOriginalExtension());

        if ($file->getSize() > $this->maxSize || !in_array($ext, $this->allowedImageExtensions)) {
            abort(406, 'Image upload failed. Max size: 5MB. Allowed: ' . implode(', ', $this->allowedImageExtensions));
        }

        if ($old) {
            $this->deleteImage($old);
        }

        $path = 'assets/general/images/';
        $name = Str::random(20) . '.' . $ext;

        if (!$file->move(public_path($path), $name)) {
            abort(406, 'Failed to save uploaded image.');
        }

        return str_replace('assets/', '', $path . $name);
    }

    public function uploadFile($file, $old = null): ?string
    {
        if (!$file->isValid()) {
            abort(406, 'Invalid file.');
        }

        $ext = strtolower($file->getClientOriginalExtension());

        if ($file->getSize() > $this->maxSize || !in_array($ext, $this->allowedFileExtensions)) {
            abort(406, 'File upload failed. Max size: 5MB. Allowed: ' . implode(', ', $this->allowedFileExtensions));
        }

        if ($old) {
            $this->deleteFile($old);
        }

        $path = 'assets/general/files/';
        $name = Str::random(20) . '.' . $ext;

        if (!$file->move(public_path($path), $name)) {
            abort(406, 'Failed to save uploaded file.');
        }

        return str_replace('assets/', '', $path . $name);
    }

    public function deleteImage($path): void
    {
        $fullPath = public_path('assets/' . $path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    public function deleteFile($path): void
    {
        $fullPath = public_path('assets/' . $path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
