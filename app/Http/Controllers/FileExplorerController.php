<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class FileExplorerController extends Controller
{
    public function index($path = null)
    {
        return $this->showFiles($path);
    }

    private function showFiles($path = null)
    {
        $baseDirectory = storage_path('app/public');
        $currentPath = $path ? $baseDirectory . '/' . $path : $baseDirectory;

        if (!is_dir($currentPath)) {
            abort(404, 'Directory not found.');
        }

        $directories = array_map('basename', array_filter(glob($currentPath . '/*'), 'is_dir'));
        $files = array_map('basename', array_filter(glob($currentPath . '/*'), 'is_file'));

        $menuItems = $this->getMenuItems($path);

        return view('file-explorer.index', [
            'directories' => $directories,
            'files' => $files,
            'breadcrumbs' => $path ? explode('/', $path) : [],
            'currentPath' => $path,
            'menuItems' => $menuItems,
        ]);
    }

    private function getMenuItems($currentPath = null)
    {
        $baseDirectory = storage_path('app/public');
        $fullPath = $currentPath ? $baseDirectory . '/' . $currentPath : $baseDirectory;
        $directories = array_map('basename', array_filter(glob($fullPath . '/*'), 'is_dir'));

        $menuItems = [
            ['icon' => 'bx bx-home', 'label' => 'My Files', 'route' => route('file-explorer.index')],
        ];

        foreach ($directories as $directory) {
            $submenu = $this->getSubMenuItems($fullPath . '/' . $directory);
            $menuItems[] = [
                'icon' => 'bx bx-folder',
                'label' => $directory,
                'route' => route('file-explorer.index', $currentPath ? $currentPath . '/' . $directory : $directory),
                'submenu' => $submenu
            ];
        }

        return $menuItems;
    }

    private function getSubMenuItems($path)
    {
        $directories = array_map('basename', array_filter(glob($path . '/*'), 'is_dir'));
        $submenu = [];

        foreach ($directories as $directory) {
            $submenu[] = [
                'icon' => 'bx bx-folder',
                'label' => $directory,
                'route' => route('file-explorer.index', $path . '/' . $directory)
            ];
        }

        return $submenu;
    }

    public function download($path)
    {
        $filePath = storage_path('app/public/' . $path);

        if (!file_exists($filePath) || is_dir($filePath)) {
            abort(404, 'File not found.');
        }

        return response()->download($filePath);
    }

    public function delete($path)
    {
        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404, 'File or directory not found.');
        }

        $trashPath = storage_path('app/public/trash/' . basename($fullPath));
        if (is_file($fullPath)) {
            rename($fullPath, $trashPath);
        } elseif (is_dir($fullPath)) {
            $this->moveDirectory($fullPath, $trashPath);
        }

        return redirect()->route('file-explorer.index', ['path' => dirname($path)])->with('success', 'Item moved to trash successfully.');
    }

    private function moveDirectory($sourceDir, $destinationDir)
    {
        if (!file_exists($sourceDir)) {
            return true;
        }

        if (!is_dir($sourceDir)) {
            return false;
        }

        if (!mkdir($destinationDir, 0755, true) && !is_dir($destinationDir)) {
            return false;
        }

        foreach (scandir($sourceDir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            $sourcePath = $sourceDir . DIRECTORY_SEPARATOR . $item;
            $destinationPath = $destinationDir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($sourcePath)) {
                if (!$this->moveDirectory($sourcePath, $destinationPath)) {
                    return false;
                }
            } else {
                if (!rename($sourcePath, $destinationPath)) {
                    return false;
                }
            }
        }

        return rmdir($sourceDir);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'nullable|string',
        ]);

        $path = $request->input('path', '');
        $fullPath = storage_path('app/public/' . $path);

        if (!is_dir($fullPath)) {
            abort(404, 'Directory not found.');
        }

        $file = $request->file('file');
        $file->move($fullPath, $file->getClientOriginalName());

        return redirect()->route('file-explorer.index', ['path' => $path])->with('success', 'File uploaded successfully.');
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string',
            'path' => 'nullable|string',
        ]);

        $path = $request->input('path', '');
        $folderName = $request->input('folder_name');
        $fullPath = storage_path('app/public/' . $path . '/' . $folderName);

        if (!is_dir(storage_path('app/public/' . $path))) {
            abort(404, 'Directory not found.');
        }

        if (!mkdir($fullPath, 0755, true) && !is_dir($fullPath)) {
            abort(500, 'Failed to create folder.');
        }

        return redirect()->route('file-explorer.index', ['path' => $path])->with('success', 'Folder created successfully.');
    }

    public function createFile(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string',
            'path' => 'nullable|string',
        ]);

        $path = $request->input('path', '');
        $fileName = $request->input('file_name');
        $fullPath = storage_path('app/public/' . $path . '/' . $fileName);

        if (!is_dir(storage_path('app/public/' . $path))) {
            abort(404, 'Directory not found.');
        }

        if (!file_put_contents($fullPath, '')) {
            abort(500, 'Failed to create file.');
        }

        return redirect()->route('file-explorer.index', ['path' => $path])->with('success', 'File created successfully.');
    }

    public function moveFile(Request $request)
    {
        $request->validate([
            'source_path' => 'required|string',
            'destination_path' => 'required|string',
        ]);

        $sourcePath = $request->input('source_path');
        $destinationPath = $request->input('destination_path');

        $fullSourcePath = storage_path('app/public/' . $sourcePath);
        $fullDestinationPath = storage_path('app/public/' . $destinationPath);

        if (!file_exists($fullSourcePath)) {
            return response()->json(['success' => false, 'message' => 'Source file not found.'], 404);
        }

        if (!is_dir($fullDestinationPath)) {
            return response()->json(['success' => false, 'message' => 'Destination directory not found.'], 404);
        }

        $fileName = basename($fullSourcePath);
        $fullDestinationFilePath = $fullDestinationPath . '/' . $fileName;

        if (!rename($fullSourcePath, $fullDestinationFilePath)) {
            return response()->json(['success' => false, 'message' => 'Failed to move file.'], 500);
        }

        return response()->json(['success' => true, 'message' => 'File moved successfully.']);
    }

    public function trash()
    {
        $trashDirectory = storage_path('app/public/trash');

        if (!is_dir($trashDirectory)) {
            mkdir($trashDirectory, 0755, true);
        }

        $files = array_map('basename', array_filter(glob($trashDirectory . '/*'), 'is_file'));

        return view('file-explorer.trash', [
            'files' => $files,
        ]);
    }

    public function restore($path)
    {
        $trashDirectory = storage_path('app/public/trash');
        $fullPath = $trashDirectory . '/' . $path;

        if (!file_exists($fullPath)) {
            abort(404, 'File not found.');
        }

        $fileName = basename($fullPath);
        $destinationPath = storage_path('app/public/' . $fileName);

        if (!rename($fullPath, $destinationPath)) {
            abort(500, 'Failed to restore file.');
        }

        return redirect()->route('file-explorer.index')->with('success', 'File restored successfully.');
    }

    public function deletePermanently($path)
    {
        $trashDirectory = storage_path('app/public/trash');
        $fullPath = $trashDirectory . '/' . $path;

        if (!file_exists($fullPath)) {
            abort(404, 'File not found.');
        }

        if (is_file($fullPath)) {
            unlink($fullPath);
        } elseif (is_dir($fullPath)) {
            $this->deleteDirectory($fullPath);
        }

        return redirect()->route('file-explorer.trash')->with('success', 'Item deleted permanently.');
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            $sourcePath = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($sourcePath)) {
                if (!$this->deleteDirectory($sourcePath)) {
                    return false;
                }
            } else {
                if (!unlink($sourcePath)) {
                    return false;
                }
            }
        }

        return rmdir($dir);
    }
}
