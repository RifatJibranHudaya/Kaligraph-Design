<?php

namespace App\Http\Controllers;

use App\Models\Production;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProduksiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = Session::get('active_branch_id', $user->branch_id);

        $query = Production::with(['user', 'editor', 'branch'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_item', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $productions = $query->latest('tanggal')->latest('id')->paginate(15);
        $totalBiaya = (clone $query)->sum('harga');

        return view('produksi.index', compact('productions', 'totalBiaya'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_item'  => 'required|string|max:150',
            'harga'      => 'required|numeric|min:0',
            'supplier'   => 'nullable|string|max:100',
            'tempat'     => 'nullable|string|max:100',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $user = Auth::user();
        $branchId = Session::get('active_branch_id', $user->branch_id);

        $production = Production::create([
            'user_id'    => $user->id,
            'branch_id'  => $branchId,
            'nama_item'  => $validated['nama_item'],
            'harga'      => $validated['harga'],
            'supplier'   => $validated['supplier'] ?? null,
            'tempat'     => $validated['tempat'] ?? null,
            'tanggal'    => $validated['tanggal'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        ActivityLogService::log(
            'add_production',
            'produksi',
            "Catatan produksi '{$production->nama_item}' (Rp " . number_format($production->harga, 0, ',', '.') . ") ditambahkan",
            $production->id
        );

        return back()->with('success', 'Catatan produksi berhasil ditambahkan.');
    }

    public function show(Production $produksi)
    {
        $produksi->load(['user', 'editor', 'branch']);
        return response()->json($produksi);
    }

    public function update(Request $request, Production $produksi)
    {
        $validated = $request->validate([
            'nama_item'  => 'required|string|max:150',
            'harga'      => 'required|numeric|min:0',
            'supplier'   => 'nullable|string|max:100',
            'tempat'     => 'nullable|string|max:100',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $user = Auth::user();

        $validated['edited_by'] = $user->id;
        $validated['edited_at'] = now();

        $produksi->update($validated);

        ActivityLogService::log(
            'update_production',
            'produksi',
            "Catatan produksi '{$produksi->nama_item}' diperbarui oleh {$user->username}",
            $produksi->id
        );

        return back()->with('success', 'Catatan produksi berhasil diperbarui.');
    }

    public function destroy(Production $produksi)
    {
        $nama = $produksi->nama_item;
        $id = $produksi->id;

        $produksi->delete();

        ActivityLogService::log('delete_production', 'produksi', "Catatan produksi '{$nama}' dihapus", $id);

        return back()->with('success', 'Catatan produksi berhasil dihapus.');
    }
}
