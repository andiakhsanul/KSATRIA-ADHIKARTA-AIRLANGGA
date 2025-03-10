<?php

namespace App\Http\Controllers;

use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TimController extends Controller
{
    public function index()
    {
        $tim = Auth::user()->tim;
        return view('Tim.index', compact('tim'));
    }
    public function create()
    {
        return view('Tim.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'proposal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'anggota.*.nama_lengkap' => 'required|string|max:255',
            'anggota.*.nim' => 'nullable|string|unique:users,nim',
            'anggota.*.nip' => 'nullable|string|unique:users,nip',
            'anggota.*.email' => 'required|email|unique:users,email',
        ]);

        $proposalPath = null;
        if ($request->hasFile('proposal')) {
            $proposalPath = $request->file('proposal')->store('proposals', 'public');
        }

        // Simpan data tim
        $tim = TimModel::create([
            'ketua_id' => Auth::id(),
            'nama_tim' => str_replace(' ', '-', $request->nama_tim),
            'proposal_path' => $proposalPath
        ]);

        // Ambil user yang sedang login
        $ketua = Auth::user();

        // Set tim_id untuk ketua
        $ketua->tim_id = $tim->id;
        $ketua->save();

        // Simpan anggota tim
        foreach ($request->anggota as $anggota) {
            User::create([
                'nama_lengkap' => $anggota['nama_lengkap'],
                'nim' => $anggota['nim'] ?? null,
                'nip' => $anggota['nip'] ?? null,
                'email' => $anggota['email'],
                'tim_id' => $tim->id,
                'role_id' => 3, // tim
                'password' => bcrypt('password123')
            ]);
        }



        return redirect()->route('tim.index', Auth::id())->with('success', 'Tim berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $tim = TimModel::findOrFail($id);

        // Update nama tim
        $tim->nama_tim = $request->nama_tim;
        $tim->save();

        // Perbarui anggota tim
        if ($request->anggota) {
            foreach ($request->anggota as $anggota) {
                $user = User::where('email', $anggota['email'])->first();

                if ($user) {
                    // Jika user ditemukan, perbarui tim_id
                    $user->tim_id = $tim->id;
                    $user->save();
                } else {
                    // Jika user tidak ditemukan, buat user baru
                    User::create([
                        'nama_lengkap' => $anggota['nama'],
                        'nim' => $anggota['nim'],
                        'email' => $anggota['email'],
                        'tim_id' => $tim->id,
                        'password' => bcrypt('password123'), // Default password
                    ]);
                }
            }
        }

        return redirect()->route('tim.index')->with('success', 'Tim berhasil diperbarui!');
    }


    public function addAnggota(Request $request, $tim_id)
    {
        $tim = TimModel::findOrFail($tim_id);

        // Ambil data dari request (hanya satu anggota)
        $data = $request->anggota[0];

        // Cek apakah user dengan NIM ini sudah ada
        $user = User::where('nim', $data['nim'])->first();

        if (!$user) {
            // Jika belum ada, buat user baru
            $user = new User();
            $user->nama_lengkap = $data['nama_lengkap'];
            $user->nim = $data['nim'];
            $user->email = $data['email'];
            $user->role_id = 3;
        }

        // Set tim_id dan simpan
        $user->tim_id = $tim->id;
        $user->save();

        return redirect()->back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function editAnggota(Request $request, $tim_id, $user_id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        $user = User::findOrFail($user_id);
        $user->nama_lengkap = $request->nama_lengkap;
        $user->nim = $request->nim;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()
            ->with('success', 'Data anggota berhasil diperbarui.');
    }
    public function removeAnggota($tim_id, $user_id)
    {
        $tim = TimModel::findOrFail($tim_id);
        $user = User::findOrFail($user_id);

        if ($user->tim_id !== $tim->id) {
            return redirect()->back()->with('error', 'User bukan anggota tim ini.');
        }

        // Set tim_id to null instead of detach()
        $user->tim_id = null;
        $user->save();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
    }


    public function delete($id)
    {
    }
}
