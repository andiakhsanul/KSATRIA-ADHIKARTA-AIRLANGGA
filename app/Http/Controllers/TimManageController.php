<?php

namespace App\Http\Controllers;

use App\Models\TimModel;
use App\Models\User;
use Illuminate\Http\Request;

class TimManageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $tim = TimModel::select('id', 'ketua_id', 'nama_tim', 'pkm_id')
            ->when($search, function ($query, $search) {
                $query->where('nama_tim', 'like', "%{$search}%"); // Search by team name
            })
            ->with([
                'anggota:id,nama_lengkap,nim,tim_id',
                'jenisPkm:id,nama_pkm',
                'ketua:id,nama_lengkap,nim'
            ])
            ->paginate(10)
            ->withQueryString(); // Preserve search query on pagination links

        return view('Operator.Tim.Index', compact('tim'));
    }

    public function edit($id)
    {
        $data = TimModel::find($id);
        return view('Operator.Tim.Edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // $data = TimModel::find($id) = update($request->only(['name', 'description']));

        return redirect()->route('tim.index')->with('success', 'Tim updated successfully');
    }

    public function delete($id)
    {
        $data = TimModel::find($id)->delete();
        return redirect()->back()->with('success', 'Tim deleted successfully');
    }
}
