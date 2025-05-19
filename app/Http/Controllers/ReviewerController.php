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
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = ApprovedTeamsModel::with([
            'tim:id,nama_tim,username,password,ketua_id,pkm_id',
            'tim.ketua:id,nama_lengkap,nim',
            'tim.jenisPkm:id,nama_pkm',
            'tim.proposal:id,judul_proposal,status,tim_id',
            'reviewer:id,nama_lengkap'
        ])
            ->join('tim', 'tim.id', '=', 'approved_teams.tim_id')
            ->join('users as ketua', 'tim.ketua_id', '=', 'ketua.id')
            ->join('proposal', 'tim.id', '=', 'proposal.tim_id')
            ->select('approved_teams.*') // Avoid duplicate column errors
            ->orderBy('tim.username');

        // Search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $search = strtolower($search); // Normalize for case-insensitive search
                $q->whereRaw('LOWER(tim.nama_tim) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(ketua.nama_lengkap) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(proposal.judul_proposal) LIKE ?', ["%{$search}%"]);
            });
        }

        // Role-based filtering
        if (Auth::user()->role_id === 1) {
            $approved_teams = $query->paginate(10);
        } else {
            $approved_teams = $query->where('approved_teams.reviewer_id', Auth::id())->paginate(10);
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
