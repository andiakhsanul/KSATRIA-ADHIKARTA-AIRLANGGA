<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::select([
            'users.id',
            'users.nim',
            'users.nip',
            'users.nama_lengkap',
            'users.email',
            'users.status',
            'role.id as role_id',
            'role.nama_role',
            DB::raw('(EXISTS (SELECT 1 FROM tim WHERE tim.ketua_id = users.id)) AS isKetua') // Optimized check
        ])
            ->join('role', 'users.role_id', '=', 'role.id')
            ->orderBy('users.created_at', 'desc');

        // Filter berdasarkan role_id jika ada
        if ($request->filled('role_id')) {
            $query->where('users.role_id', $request->role_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.nama_lengkap', 'like', "%$search%")
                  ->orWhere('users.email', 'like', "%$search%")
                  ->orWhere('users.nim', 'like', "%$search%")
                  ->orWhere('users.nip', 'like', "%$search%");
            });
        }

        if ($request->ajax()) {
            return response()->json($query->get());
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = DB::table('role')->select('id', 'nama_role')->get();

        return view('Operator.User.index', compact('users', 'roles'));
    }


    public function create()
    {
        return view('Operator.User.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|unique:users,nim|max:15',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|integer|exists:role,id'
        ]);

        User::create([
            'nim' => $request->nim,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => 1,
            'role_id' => $request->role_id
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 1]);

        return redirect()->back()->with('success', 'User berhasil disetujui.');
    }
    public function declineUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 3]);

        return redirect()->back()->with('success', 'User berhasil ditolak.');
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $role = RoleModel::select('id', 'nama_role')->get();

        return view('Operator.User.edit', compact('user', 'role'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'nim' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'nim.max' => 'NIM tidak boleh lebih dari 255 karakter.',
            'nip.max' => 'NIP tidak boleh lebih dari 255 karakter.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'nim' => $request->nim,
            'nip' => $request->nip,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    // ✅ Delete User (Check Existence First)
    public function delete($id)
    {
        $user = User::where('id', $id)->first();

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }

        $isKetua = TimModel::where('ketua_id', $id)->exists();

        if ($isKetua) {
            return redirect()->route('user.index')->with('error', $user->nama_lengkap . ' adalah ketua dan tidak bisa dihapus.');
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }

}
