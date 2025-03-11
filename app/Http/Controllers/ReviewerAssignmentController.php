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

        $teams = TimModel::with(['jenisPkm', 'reviewers'])->get();

        return view('Reviewer.index', compact('reviewers', 'teams'));
    }


    public function assign(Request $request)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
            'tim_ids' => 'required|array',
            'tim_ids.*' => 'exists:tim,id',
        ]);

        $reviewer = User::findOrFail($request->reviewer_id);
        $assignedTeams = [];

        foreach ($request->tim_ids as $tim_id) {
            // Cek jumlah reviewer yang sudah ada untuk tim ini
            $reviewerCount = DB::table('reviewer_tim')->where('tim_id', $tim_id)->count();

            if ($reviewerCount < 2) {
                $assignedTeams[] = $tim_id;
            }
        }

        if (!empty($assignedTeams)) {
            $reviewer->teamsReviewed()->syncWithoutDetaching($assignedTeams);
            return redirect()->route('reviewers.assign')->with('success', 'Reviewer assigned successfully!');
        } else {
            return redirect()->route('reviewers.assign')->with('error', 'Each team can only have up to 2 reviewers.');
        }
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
        $teams = TimModel::with('jenisPkm', 'reviewers')
            ->get()
            ->filter(function ($team) {
                return count($team->reviewers) < 2; 
            });
        $pkmTypes = JenisPKMModel::select('id', 'nama_pkm')->get();

        return view('Reviewer.assign', compact('reviewers', 'teams', 'pkmTypes'));
    }

}
