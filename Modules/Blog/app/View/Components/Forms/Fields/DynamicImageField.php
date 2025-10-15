<?php

namespace Modules\Blog\View\Components\Forms\Fields;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DynamicImageField extends Component
{
    /**
     * Create a new component instance.
     */
    public $label;
    public $name;
    public $value;
    public $path;

    public function __construct($label = 'Image', $name = 'image', $value = null, $path = 'blogs/posts/images/')
    {
        $this->label = $label;
        $this->name = $name;
        $this->value = $value;
        $this->path = $path;
    }


    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        $request = request(); // Get current request instance
    
        $folder = trim($request->input('folder', ''));
        $basePath = public_path('uploads/files');
        $targetPath = $basePath . ($folder ? DIRECTORY_SEPARATOR . $folder : '');
    
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0755, true);
        }
    
        $folders = collect(File::directories($targetPath))->map(function ($path) use ($basePath) {
            $relativePath = \Str::after($path, $basePath . DIRECTORY_SEPARATOR);
            return [
                'name' => basename($path),
                'path' => $relativePath
            ];
        });
    
        $files = collect(File::files($targetPath))->map(function ($file) use ($folder) {
            $name = $file->getFilename();
            return [
                'name' => $name,
                'url' => asset('uploads/files/' . ($folder ? $folder . '/' : '') . $name)
            ];
        });
    
        $parentFolder = dirname($folder);
        if ($parentFolder === '.' || $parentFolder === '/') {
            $parentFolder = '';
        }
    
        return view('blog::components.forms.fields.dynamic-image-field', [
            'files' => $files,
            'folders' => $folders,
            'currentFolder' => $folder,
            'parentFolder' => $parentFolder,
        ]);
    }
    
}
