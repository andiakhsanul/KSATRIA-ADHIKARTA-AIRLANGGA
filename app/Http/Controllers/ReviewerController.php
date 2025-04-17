<?php

namespace App\Http\Controllers;

use App\Models\ApprovedTeamsModel;
use App\Models\ReviewTimModel;
use App\Models\TimModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReviewerController extends Controller
{
    public function index()
    {
        $query = ApprovedTeamsModel::with([
            'tim:id,nama_tim,username,password',
            'tim.proposal:id,judul_proposal,status,tim_id',
            'reviewer:id,nama_lengkap'
        ])
            ->join('tim', 'tim.id', '=', 'approved_teams.tim_id') // Join tim table
            ->orderBy('tim.username'); // Now ordering correctly using tim.username

        // Check if the user has role_id 1
        if (Auth::user()->role_id === 1) {
            // When role_id is 1, get all approved teams, including the necessary data
            $approved_teams = $query->paginate(10);
        } else {
            // When not role_id 1, filter by reviewer_id
            $approved_teams = $query->where('reviewer_id', Auth::id())->paginate(10);
        }

        return view('Operator.Proposal.ApprovedTeams', compact('approved_teams'));
    }

    public function approveTeam($tim_id)
    {
        $reviewer_id = Auth::id();

        $alreadyApproved = ApprovedTeamsModel::where('tim_id', $tim_id)
            ->where('reviewer_id', $reviewer_id)
            ->where('is_approved', true)
            ->exists();

        if ($alreadyApproved) {
            return redirect()->back()->with('error', 'Tim Sudah di loloskan oleh anda.');
        }

        // Update or create the review record
        ApprovedTeamsModel::updateOrCreate(
            ['tim_id' => $tim_id, 'reviewer_id' => $reviewer_id],
            ['is_approved' => true]
        );


        return redirect()->back()->with('success', 'Team approved successfully.');
    }

    public function addCredentials(Request $request, $tim_id)
    {
        // Hitung jumlah reviewer yang sudah menyetujui tim ini
        $approvedCount = ApprovedTeamsModel::where('tim_id', $tim_id)
            ->where('is_approved', true)
            ->count();

        // // Cek apakah sudah disetujui minimal 2 reviewer
        if ($approvedCount < 2) {
            return redirect()->back()->with([
                'error' => 'Tim ini belum disetujui oleh minimal 2 reviewer.'
            ]);
        }

        // $existing = ApprovedTeamsModel::where('tim_id', '=', $tim_id)->first();
        // if ($existing) {
        //     return redirect()->back()->with(['error' => 'Kredensial sudah ada untuk tim ini.'], 409);
        // }

        TimModel::where('id', '=', $tim_id)->update([
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return redirect()->back()->with([
            'success' => 'Kredensial berhasil dibuat.',
        ]);
    }

    public function delete($tim_id)
    {
        $team = ApprovedTeamsModel::where('tim_id', '=', $tim_id)
            ->where('reviewer_id', '=', Auth::id());

        if (!$team) {
            return redirect()->back()->with('error', 'Data tim tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $team->delete();

        return redirect()->back()->with('success', 'team deleted');
    }
}
