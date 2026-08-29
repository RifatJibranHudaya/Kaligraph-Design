<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount(['users', 'orders'])->get();
        return view('branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'alamat'      => 'nullable|string',
            'map_url'     => 'nullable|string',
            'map_iframe'  => 'nullable|string',
        ], [
            'nama_cabang.required' => 'Nama cabang toko wajib diisi.',
        ]);

        $branch = Branch::create($validated);

        ActivityLogService::log('create_branch', 'branches', "Cabang '{$branch->nama_cabang}' ditambahkan", $branch->id);

        return back()->with('success', "Cabang '{$branch->nama_cabang}' berhasil ditambahkan.");
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'alamat'      => 'nullable|string',
            'map_url'     => 'nullable|string',
            'map_iframe'  => 'nullable|string',
        ], [
            'nama_cabang.required' => 'Nama cabang toko wajib diisi.',
        ]);

        $branch->update($validated);

        ActivityLogService::log('update_branch', 'branches', "Cabang '{$branch->nama_cabang}' diperbarui", $branch->id);

        return back()->with('success', "Cabang '{$branch->nama_cabang}' berhasil diperbarui.");
    }

    public function destroy(Branch $branch)
    {
        $nama = $branch->nama_cabang;
        $id = $branch->id;

        $branch->delete();

        ActivityLogService::log('delete_branch', 'branches', "Cabang '{$nama}' dihapus", $id);

        return back()->with('success', "Cabang '{$nama}' berhasil dihapus.");
    }
}
