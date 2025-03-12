<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request, $proposal_id)
    {
        $validator = Validator::make($request->all(), [
            'comments' => 'required|string',
            'file' => 'nullable|mimes:pdf,docx|max:20480',
        ], [
            'comments.required' => 'Komentar wajib diisi.',
            'file.mimes' => 'File harus berformat PDF atau DOCX.',
            'file.max' => 'Ukuran file maksimal 20MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $filePath = $request->file ? $request->file('file')->store('reviews') : null;

        ReviewModel::create([
            'proposal_id' => $proposal_id,
            'comments' => $request->comments,
            'file' => $filePath,
            'user_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Review berhasil ditambahkan.');
    }
}
