<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DynamicMultipleImageField extends Component
{
    public string $label;
    public string $name;
    public $values;   // handles multiple values
    public string $path;
    public bool $multiple;

    public function __construct(
        string $label = 'Images',
        string $name = 'images',
        $values = [],
        string $path = 'uploads/files',
        bool $multiple = true
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->values = $values;
        $this->path = $path;
        $this->multiple = $multiple;
    }

    public function render(): View|string
    {
        $request = request();

        $folder = trim($request->input('folder', ''));
        $basePath = public_path($this->path);
        $targetPath = $basePath . ($folder ? DIRECTORY_SEPARATOR . $folder : '');

        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        // Get Folders
        $folders = collect(File::directories($targetPath))->map(function ($path) use ($basePath) {
            $relativePath = Str::after($path, $basePath . DIRECTORY_SEPARATOR);
            return [
                'name' => basename($path),
                'path' => $relativePath
            ];
        });

        // Get Files
        $files = collect(File::files($targetPath))->map(function ($file) use ($folder) {
            $name = $file->getFilename();
            return [
                'name' => $name,
                'url' => asset(trim($this->path, '/') . '/' . ($folder ? $folder . '/' : '') . $name)
            ];
        });

        $parentFolder = dirname($folder);
        if ($parentFolder === '.' || $parentFolder === '/') {
            $parentFolder = '';
        }

        return view('blog::components.forms.fields.dynamic-multiple-image-field', [
            'files' => $files,
            'folders' => $folders,
            'currentFolder' => $folder,
            'parentFolder' => $parentFolder,
        ]);
    }
}
