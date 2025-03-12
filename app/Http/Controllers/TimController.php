<?php

namespace App\Http\Controllers;

use App\Models\JenisPKMModel;
use App\Models\ProposalModel;
use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TimController extends Controller
{
    public function index()
    {
        $tim = Auth::user()->tim;
        return view('Tim.index', compact('tim'));
    }
    public function create()
    {
        $pkm = JenisPKMModel::select('id', 'nama_pkm')->get();
        return view('Tim.create', compact('pkm'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_tim' => 'required|string|max:255|unique:tim,nama_tim',
            'proposal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'pkm_id' => 'required',
        ], [
            'nama_tim.unique' => 'Tim dengan nama :input sudah terdaftar.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $proposalPath = null;

        // Simpan data tim
        $tim = TimModel::create([
            'ketua_id' => Auth::id(),
            'nama_tim' => str_replace(' ', '-', $request->nama_tim),
            'proposal_path' => $proposalPath,
            'pkm_id' => $request->pkm_id
        ]);


        // Ambil user yang sedang login
        $ketua = Auth::user();

        // Set tim_id untuk ketua
        $ketua->tim_id = $tim->id;
        $ketua->save();

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

        if ($user) {
            // Jika user sudah memiliki tim, kembalikan error
            if ($user->tim_id) {
                return back()->with('error', 'Anggota sudah join tim');
            } else {
                // Jika user sudah ada tetapi belum punya tim, update tim_id saja
                $user->tim_id = $tim->id;
                $user->save();
                return redirect()->back()->with('success', 'Anggota berhasil ditambahkan ke tim.');
            }
        } else {
            // Jika user belum ada, buat user baru
            $user = new User();
            $user->nama_lengkap = $data['nama_lengkap'];
            $user->nim = $data['nim'];
            $user->role_id = 3;
            $user->status = 1;
            $user->tim_id = $tim->id;
            $user->save();

            return redirect()->back()->with('success', 'Anggota baru berhasil ditambahkan.');
        }
    }


    public function editAnggota(Request $request, $tim_id, $user_id)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
        ]);

        $user = User::findOrFail($user_id);
        $user->nama_lengkap = $request->nama_lengkap;
        $user->nim = $request->nim;
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

        if ($tim->ketua_id == $user->id) {
            return redirect()->back()->with('error', 'User adalah ketua tim, Mohon Kontak Admin jika ingin menghapus kelompok ini !.');
        }

        $user->tim_id = null;
        $user->save();

        return redirect()->back()->with('success', 'Anggota berhasil dihapus.');
    }


    public function delete($id)
    {
    }
}
