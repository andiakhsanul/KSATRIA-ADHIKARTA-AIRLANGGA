<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function viewFile($folder, $filename)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $allowedFolders = ['reviews', 'proposals', 'revisions'];
        if (!in_array($folder, $allowedFolders)) {
            abort(400, 'Invalid folder');
        }

        $fullPath = storage_path("app/private/{$folder}/{$filename}");

        if (!file_exists($fullPath)) {
            return response()->json([
                'error' => 'File not found',
                'checked_path' => $fullPath
            ], 404);
        }

        return response()->file($fullPath);
    }



    public function downloadFile(Request $request, $file_path)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Cek apakah file ada di storage
        if (!Storage::exists("private/{$file_path}")) {
            return response()->json([
                'error' => 'File not found',
                'checked_path' => storage_path("app/private/{$file_path}")
            ], 404);
        }

        return Storage::download("private/{$file_path}");
    }
}
