<?php

namespace Modules\Media\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $folder = trim($request->input('folder', ''));
        $basePath = public_path('uploads/files');
        $targetPath = $basePath . ($folder ? DIRECTORY_SEPARATOR . $folder : '');

        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0755, true);
        }

        $folders = collect(File::directories($targetPath))->map(function ($path) use ($basePath) {
            $relativePath = Str::after($path, $basePath . DIRECTORY_SEPARATOR);
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
        if ($parentFolder === '.' || $parentFolder === '/') $parentFolder = '';

        return view('media::index', [
            'files' => $files,
            'folders' => $folders,
            'currentFolder' => $folder,
            'parentFolder' => $parentFolder,
        ]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file'); 
            $folder = trim($request->input('folder', '')); 
            $filename = time() . '_' . $file->getClientOriginalName();

            $uploadPath = public_path('uploads/files/' . ($folder ? $folder . '/' : ''));
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file->move($uploadPath, $filename);

            return response()->json([
                'success' => true,
                'url' => asset('uploads/files/' . ($folder ? $folder . '/' : '') . $filename)
            ]);
        }

        return response()->json(['success' => false], 400);
    }
    public function uploadMulti(Request $request)
    {
        $folder = $request->input('folder', 'uploads/files');
        $paths = [];

        foreach ($request->file('files') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs($folder, $filename, 'public');
            $paths[] = '/storage/' . $path;
        }

        return response()->json([
            'success' => true,
            'paths' => $paths,
        ]);
    }

    public function createFolder(Request $request)
    {
        $folderName = trim($request->input('name'));
        $baseFolder = trim($request->input('base', ''));

        if (!$folderName) {
            return response()->json(['success' => false, 'message' => 'Folder name is required.']);
        }

        $safeName = Str::slug($folderName, '_');
        $fullPath = public_path('uploads/files/' . ($baseFolder ? $baseFolder . '/' : '') . $safeName);

        if (file_exists($fullPath)) {
            return response()->json(['success' => false, 'message' => 'Folder already exists.']);
        }

        if (!mkdir($fullPath, 0755, true)) {
            return response()->json(['success' => false, 'message' => 'Failed to create folder.']);
        }

        return response()->json(['success' => true]);
    }

    public function deleteFolder(Request $request)
    {
        $folderPath = $request->input('folder');

        $fullPath = public_path('uploads/files/' . $folderPath);

        if (!File::exists($fullPath)) {
            return response()->json(['success' => false, 'message' => 'Folder does not exist.'], 404);
        }

        try {
            File::deleteDirectory($fullPath);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Could not delete folder.'], 500);
        }
    }
    
    public function rename(Request $request)
    {
        $folder = trim($request->input('folder', ''));
        $oldName = basename($request->input('old_name'));
        $newName = basename($request->input('new_name'));
    
        $oldPath = public_path("uploads/files/" . ($folder ? $folder . '/' : '') . $oldName);
        $newPath = public_path("uploads/files/" . ($folder ? $folder . '/' : '') . $newName);
    
        if (file_exists($oldPath)) {
            rename($oldPath, $newPath);
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'File not found.']);
    }
    
    public function crop(Request $request)
    {
        $folder = trim($request->input('folder', ''));
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = public_path("uploads/files/" . ($folder ? $folder . '/' : '') . $file->getClientOriginalName());
            $file->move(dirname($path), basename($path)); // overwrite
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }
    
    public function delete(Request $request)
    {
        $folder = trim($request->input('folder', ''));
        $file = basename($request->input('filename'));
        $path = public_path("uploads/files/" . ($folder ? $folder . '/' : '') . $file);

        if (file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}