<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function viewFile(Request $request, $folder, $filename)
    {
        // Ensure the user is logged in and has role_id == 1
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Ensure the folder is one of the allowed folders
        $allowedFolders = ['reviews', 'proposals', 'revisi'];
        if (!in_array($folder, $allowedFolders)) {
            abort(400, 'Invalid folder');
        }

        // Construct the full file path
        $path = storage_path("app/private/{$folder}/{$filename}");

        // Check if the file exists
        if (!file_exists($path)) {
            abort(404);
        }

        // Serve the file
        return response()->file($path);
    }

    public function downloadFile(Request $request, $folder, $filename)
    {
        // Ensure the user is logged in and has role_id == 1
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Ensure the folder is valid
        $allowedFolders = ['reviews', 'proposals', 'revisi'];
        if (!in_array($folder, $allowedFolders)) {
            abort(400, 'Invalid folder');
        }

        // Secure file download
        return Storage::download("private/{$folder}/{$filename}");
    }
}
