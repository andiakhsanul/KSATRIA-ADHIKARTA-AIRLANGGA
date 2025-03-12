<?php

namespace App\Http\Controllers;

use App\Models\CommentsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function store(Request $request, $revisi_id)
    {
        $data = $request->validate([
            'lampiran_revisi' => 'nullable|file|mimes:docx|max:10000',
            'comment' => 'nullable|string'
        ]);

        $filePath = null;

        if ($request->hasFile('lampiran_revisi')) {
            $user = Auth::user();
            $todayDate = Carbon::now()->format('Ymd');
            $timeStamp = Carbon::now()->format('His'); // HHMMSS
            $randomString = substr(md5(uniqid()), 0, 6);
            $teamName = str_replace(' ', '_', $user->nama_tim);
            $fileExtension = $request->file('lampiran_revisi')->getClientOriginalExtension();
            $fileName = "revisi-dari-{$user->nama_lengkap}_{$todayDate}_{$timeStamp}_{$randomString}_{$teamName}.{$fileExtension}";

            // Store in private storage
            $filePath = $request->file('lampiran_revisi')->storeAs('/revisions', $fileName);
        }

        CommentsModel::create([
            'user_id' => Auth::id(),
            'revisions_id' => $revisi_id,
            'lampiran_revisi' => $filePath,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

}
