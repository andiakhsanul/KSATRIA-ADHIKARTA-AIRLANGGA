<?php

namespace App\Http\Controllers;

use App\Models\JenisPKMModel;
use App\Models\ProposalModel;
use App\Models\ReviewModel;
use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewerAssignmentController extends Controller
{
    // 📌 Menampilkan daftar reviewer dan jenis PKM yang ditugaskan
    public function index()
    {
        $reviewers = User::whereHas('role', function ($query) {
            $query->where('nama_role', 'Reviewer');
        })->with(['teamsReviewed.proposals', 'teamsReviewed.jenisPkm'])->get();

        return view('Reviewer.index', compact('reviewers'));
    }


    public function assign(Request $request)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
            'tim_ids' => 'required|array', // Accept multiple team IDs
            'tim_ids.*' => 'exists:tim,id',
        ]);

        $reviewer = User::find($request->reviewer_id);
        $reviewer->teamsReviewed()->syncWithoutDetaching($request->tim_ids); // Assign multiple teams

        return redirect()->route('reviewers.assign')->with('success', 'Reviewer assigned successfully!');
    }

    public function deleteAssignment($reviewer_id, $team_id)
    {
        DB::table('reviewer_tim')
            ->where('reviewer_id', $reviewer_id)
            ->where('tim_id', $team_id)
            ->delete();

        return back()->with('success', 'Reviewer assignment removed successfully.');
    }

    public function showAssignForm()
    {
        $reviewers = User::whereHas('role', function ($query) {
            $query->where('nama_role', 'Reviewer');
        })->get();
        $teams = TimModel::with('jenisPkm')
            ->whereDoesntHave('reviewers')
            ->get();
        $pkmTypes = JenisPKMModel::select('id', 'nama_pkm')->get();

        return view('reviewer.assign', compact('reviewers', 'teams', 'pkmTypes'));
    }

}
