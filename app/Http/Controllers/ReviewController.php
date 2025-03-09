<?php

namespace App\Http\Controllers;

use App\Models\ReviewModel;
use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $proposal_id)
    {
        $request->validate([
            'comments' => 'required|string',
            'file' => 'nullable|mimes:pdf,docx|max:20480',
        ]);

        $filePath = $request->file ? $request->file('file')->store('reviews') : null;

        ReviewModel::create([
            'proposal_id' => $proposal_id,
            'comments' => $request->comments,
            'file' => $filePath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Review berhasil ditambahkan.');
    }
}
