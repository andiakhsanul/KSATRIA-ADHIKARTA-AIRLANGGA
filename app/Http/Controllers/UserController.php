<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select(['users.id', 'users.nim', 'users.nip','users.nama_lengkap', 'users.email', 'role.nama_role'])
            ->join('role', 'users.role_id', '=', 'role.id')
            ->orderBy('users.created_at', 'desc')
            ->paginate(10);


        return view('Operator.User.index', compact('users'));
    }

    public function create()
    {
        return view('Operator.User.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|unique:users,nim|max:15',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        User::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
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
    public function delete($nim)
    {
        $user = User::where('nim', $nim)->first();

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
