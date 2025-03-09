<?php

namespace App\Http\Controllers;

use App\Models\ProposalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProposalController extends Controller
{
    public function indexOperator()
    {
        $user = Auth::user();

        // Operator
        if ($user->role_id == 1) {
            $proposals = ProposalModel::with(['tim', 'reviewers'])->latest()->get();
        } elseif ($user->role_id == 2) {
            // Reviewer hanya melihat proposal yang ditugaskan ke mereka
            $proposals = ProposalModel::whereHas('reviewers', function ($query) use ($user) {
                $query->where('reviewer_id', $user->id);
            })->with(['tim', 'reviewers'])->latest()->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('Operator.Proposal.index', compact('proposals'));
    }

    public function detailProposal($nama_tim, $tim_id)
    {
        $proposal = ProposalModel::with('tim')->where('tim_id', $tim_id)->firstOrFail();

        return view('Operator.Proposal.detail', compact('proposal'));
    }

    public function index()
    {
        $user = Auth::user();

        $proposals = ProposalModel::where('tim_id', $user->tim_id)->get();

        return view('Proposal.index', compact('proposals'));
    }

    public function show($id)
    {
        $proposal = ProposalModel::with(['reviews', 'revisions'])->findOrFail($id);
        return view('Proposal.show', compact('proposal'));
    }


    public function create()
    {
        return view('Proposal.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul_proposal' => 'required|string|max:255',
            'abstract' => 'required|string',
            'file' => 'required|mimes:pdf,docx|max:20480', // Maksimal 20MB
        ]);

        $user = Auth::user();

        // Pastikan user memiliki tim_id sebelum menyimpan proposal
        if (!$user->tim_id) {
            return redirect()->back()->with('error', 'Anda belum bergabung dengan tim.');
        }

        // Ambil nama ketua tim
        $ketuaName = Str::slug($user->nama_lengkap, '_'); // Ubah nama ketua jadi format slug (_)
        $judulProposal = Str::slug($request->judul_proposal, '_'); // Ubah judul jadi format slug (_)
        $date = Carbon::now()->format('Ymd'); // Format tanggal YYYYMMDD
        $uuid = Str::uuid(); // UUID unik untuk menghindari duplikasi nama file

        // Buat nama file
        $filename = "{$date}_{$ketuaName}_{$judulProposal}_{$uuid}.{$request->file('file')->getClientOriginalExtension()}";

        // Simpan file ke folder 'proposal'
        $path = $request->file('file')->storeAs('proposal', $filename);

        // Simpan data ke database
        ProposalModel::create([
            'judul_proposal' => $request->judul_proposal,
            'abstract' => $request->abstract,
            'tim_id' => $user->tim_id,
            'status' => 'pending',
            'file_path' => $path, // Simpan path file
        ]);

        return redirect()->back()->with('success', 'Proposal berhasil diunggah.');
    }
    public function edit()
    {
    }
    public function delete($id)
    {
        $data = ProposalModel::find($id);
        $data->delete();

        return redirect()->back()->with('success', 'Proposal Deleted Successfully');
    }
}
