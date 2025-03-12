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
            'file_revisi' => 'nullable|mimes:pdf,docx|max:20480',
        ]);

        $filePath = $request->hasFile('file_revisi')
            ? $request->file('file_revisi')->store('revisions')
            : null;

        RevisiModel::create([
            'proposal_id' => $proposal_id,
            'file_revisi' => $filePath,
            'submitted_by' => Auth::id(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Revisi berhasil diunggah.');
    }

}
