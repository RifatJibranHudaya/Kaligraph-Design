<?php

namespace App\Http\Controllers;

use App\Models\Operational;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperasionalController extends Controller
{
    public function index(Request $request)
    {
        $query = Operational::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('tempat_beli', 'like', "%{$search}%");
            });
        }

        $operationals = $query->latest('tanggal_beli')->latest('id')->paginate(15);
        $totalBiaya = (clone $query)->sum('harga');

        return view('operasional.index', compact('operationals', 'totalBiaya'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat'     => 'required|string|max:150',
            'harga'         => 'required|numeric|min:0',
            'tempat_beli'   => 'nullable|string|max:100',
            'merk'          => 'nullable|string|max:100',
            'periode_ganti' => 'nullable|integer|min:0',
            'tanggal_beli'  => 'required|date',
            'keterangan'    => 'nullable|string',
        ]);

        $user = Auth::user();

        $operational = Operational::create([
            'user_id'       => $user->id,
            'nama_alat'     => $validated['nama_alat'],
            'harga'         => $validated['harga'],
            'tempat_beli'   => $validated['tempat_beli'] ?? null,
            'merk'          => $validated['merk'] ?? null,
            'periode_ganti' => $validated['periode_ganti'] ?? null,
            'tanggal_beli'  => $validated['tanggal_beli'],
            'keterangan'    => $validated['keterangan'] ?? null,
        ]);

        ActivityLogService::log(
            'add_operational',
            'operasional',
            "Pengeluaran operasional '{$operational->nama_alat}' (Rp " . number_format($operational->harga, 0, ',', '.') . ") ditambahkan",
            $operational->id
        );

        return back()->with('success', 'Data operasional berhasil ditambahkan.');
    }

    public function update(Request $request, Operational $operasional)
    {
        $validated = $request->validate([
            'nama_alat'     => 'required|string|max:150',
            'harga'         => 'required|numeric|min:0',
            'tempat_beli'   => 'nullable|string|max:100',
            'merk'          => 'nullable|string|max:100',
            'periode_ganti' => 'nullable|integer|min:0',
            'tanggal_beli'  => 'required|date',
            'keterangan'    => 'nullable|string',
        ]);

        $operasional->update($validated);

        ActivityLogService::log(
            'update_operational',
            'operasional',
            "Pengeluaran operasional '{$operasional->nama_alat}' diperbarui",
            $operasional->id
        );

        return back()->with('success', 'Data operasional berhasil diperbarui.');
    }

    public function destroy(Operational $operasional)
    {
        $nama = $operasional->nama_alat;
        $id = $operasional->id;

        $operasional->delete();

        ActivityLogService::log('delete_operational', 'operasional', "Data operasional '{$nama}' dihapus", $id);

        return back()->with('success', 'Data operasional berhasil dihapus.');
    }
}
