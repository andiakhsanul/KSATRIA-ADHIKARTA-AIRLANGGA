<?php

namespace App\Http\Controllers;

use App\Models\JenisPKMModel;
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

    public function detailProposal($nama_tim, $proposal_id)
    {
        $proposal = ProposalModel::with('tim')
            ->select('id', 'judul_proposal', 'abstract', 'status','tim_id', 'file_path')
            ->where('id', $proposal_id)
            ->firstOrFail();

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
        $pkm = JenisPKMModel::select('id', 'nama_pkm')->get();
        return view('Proposal.create', compact('pkm'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_proposal' => 'required|string|max:255',
            'abstract' => 'required|string',
            'file' => 'required|mimes:pdf,docx|max:20480', // Maksimal 20MB
            'pkm_id' => 'required'
        ], [
            'judul_proposal.required' => 'Judul proposal harus diisi.',
            'judul_proposal.string' => 'Judul proposal harus berupa teks.',
            'judul_proposal.max' => 'Judul proposal tidak boleh lebih dari 255 karakter.',
            'abstract.required' => 'Abstract harus diisi.',
            'abstract.string' => 'Abstract harus berupa teks.',
            'file.required' => 'File harus diunggah.',
            'file.mimes' => 'File harus berformat PDF atau DOCX.',
            'file.max' => 'Ukuran file maksimal 20MB.',
            'pkm_id.required' => 'PKM ID harus diisi.'
        ]);

        
        $user = Auth::user();

        // if (!$user->tim_id) {
        //     return redirect()->back()->with('error', 'Anda belum bergabung dengan tim.');
        // }

        // Ambil nama ketua tim
        $ketuaName = Str::slug($user->nama_lengkap, '_'); // Ubah nama ketua jadi format slug (_)
        $judulProposal = Str::slug($request->judul_proposal, '_'); // Ubah judul jadi format slug (_)
        $date = Carbon::now()->format('Ymd'); // Format tanggal YYYYMMDD
        $uuid = Str::uuid(); // UUID unik untuk menghindari duplikasi nama file

        // Buat nama file
        $filename = "{$date}_{$ketuaName}_{$judulProposal}_{$uuid}.{$request->file('file')->getClientOriginalExtension()}";

        // Simpan file ke folder 'proposal'
        $path = $request->file('file')->storeAs('proposals', $filename);

        // Simpan data ke database
        ProposalModel::create([
            'judul_proposal' => $request->judul_proposal,
            'abstract' => $request->abstract,
            'tim_id' => $user->tim_id,
            'status' => 'pending',
            'file_path' => $path, 
            'pkm_id' => $request->pkm_id
        ]);

        return redirect()->route('proposal.index', Auth::user()->tim_id)->with('success', 'Proposal berhasil diunggah.');
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
