<?php

namespace App\Http\Controllers;

use App\Models\RevisiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevisiController extends Controller
{
    public function store(Request $request, $proposal_id)
    {
        $request->validate([
            'comments' => 'nullable|string',
            'file_revisi' => 'required|mimes:pdf,docx|max:20480',
        ]);

        $filePath = $request->file('file_revisi')->store('revisions');

        RevisiModel::create([
            'proposal_id' => $proposal_id,
            'comments' => $request->comments,
            'file_revisi' => $filePath,
            'submitted_by' => Auth::id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Revisi berhasil diunggah.');
    }

}
