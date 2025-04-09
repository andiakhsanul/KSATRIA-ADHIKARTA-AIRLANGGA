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
    public function indexOperator(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $jenisPkmId = $request->input('jenis_pkm_id');

        // Base query
        $query = ProposalModel::select('id', 'judul_proposal', 'tim_id', 'status', 'created_at')
            ->with(['tim:id,nama_tim']);

        // cari
        if ($search) {
            $query->where('judul_proposal', 'like', "%{$search}%");
        }

        // filter jenis pkm
        if ($jenisPkmId) {
            $query->whereHas('tim.jenisPkm', function ($q) use ($jenisPkmId) {
                $q->where('id', $jenisPkmId);
            });
        }

        // Role-based filtering
        if ($user->role_id == 1) { // Operator
            $query->with(['tim.reviewers:id,email,nama_lengkap']);
        } elseif ($user->role_id == 2) { // Dosen
            $query->whereHas('tim.reviewers', function ($q) use ($user) {
                $q->where('reviewer_id', $user->id);
            })->with([
                        'tim.reviewers:id,email,nama_lengkap',
                        'jenisPkm:id,nama_pkm'
                    ]);
        } else {
            abort(403, 'Unauthorized');
        }

        // Preserve query string for pagination
        $proposals = $query->paginate(10)->withQueryString(); 
        $listJenisPkm = JenisPKMModel::select('id', 'nama_pkm')->get();

        return view('Operator.Proposal.index', compact('proposals', 'listJenisPkm'));
    }




    public function detailProposal($nama_tim, $proposal_id)
    {
        $proposal = ProposalModel::with([
            'tim:id,nama_tim,pkm_id',
            'tim.reviewers:id,nama_lengkap',
            'reviews:id,proposal_id,comments,user_id,file,created_at',
            'reviews.user:id,nama_lengkap',
            'revisions:id,proposal_id,file_revisi,status,submitted_by,created_at,updated_at', // Ensure revisions are loaded
            'revisions.comments:id,user_id,revisions_id,comment,lampiran_revisi,created_at,updated_at',
            'revisions.comments.user:id,nama_lengkap'
        ])
            ->select('id', 'judul_proposal', 'abstract', 'tim_id', 'file_path')
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
        $proposal = ProposalModel::with([
            'tim:id,nama_tim,pkm_id',
            'tim.reviewers:id,nama_lengkap',
            'reviews:id,proposal_id,comments,user_id,file,created_at',
            'reviews.user:id,nama_lengkap',
            'revisions:id,proposal_id,file_revisi,status,submitted_by,created_at,updated_at', // Ensure revisions are loaded
            'revisions.comments:id,user_id,revisions_id,comment,lampiran_revisi,created_at,updated_at',
            'revisions.comments.user:id,nama_lengkap'
        ])
            ->select('id', 'judul_proposal', 'abstract', 'tim_id', 'file_path')
            ->where('id', $id)
            ->firstOrFail();


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
            'file' => 'required|mimes:docx|max:20480', // Maksimal 20MB
        ], [
            'judul_proposal.required' => 'Judul proposal harus diisi.',
            'judul_proposal.string' => 'Judul proposal harus berupa teks.',
            'judul_proposal.max' => 'Judul proposal tidak boleh lebih dari 255 karakter.',
            'abstract.required' => 'Abstract harus diisi.',
            'abstract.string' => 'Abstract harus berupa teks.',
            'file.required' => 'File harus diunggah.',
            'file.mimes' => 'File harus berformat DOCX.',
            'file.max' => 'Ukuran file maksimal 20MB.',
        ]);


        $user = Auth::user();

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
