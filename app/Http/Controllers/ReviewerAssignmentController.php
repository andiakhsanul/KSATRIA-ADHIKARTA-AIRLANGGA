<?php

namespace App\Http\Controllers;

use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewerAssignmentController extends Controller
{
    public function index()
    {
        $reviewers = User::where('role_id', 2)->with('teamsReviewed')->get(); // Get reviewers and their assigned teams
        $teams = TimModel::all();

        return view('Reviewer.assignments', compact('reviewers', 'teams'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
            'tim_id' => 'required|exists:tim,id',
        ]);

        $reviewer = User::find($request->reviewer_id);
        $reviewer->teamsReviewed()->syncWithoutDetaching([$request->tim_id]);

        return redirect()->route('reviewer.assignments')->with('success', 'Reviewer assigned successfully');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
            'tim_id' => 'required|exists:tim,id',
        ]);

        $reviewer = User::find($request->reviewer_id);
        $reviewer->teamsReviewed()->detach($request->tim_id);

        return redirect()->route('reviewer.assignments')->with('success', 'Reviewer removed successfully');
    }
}
