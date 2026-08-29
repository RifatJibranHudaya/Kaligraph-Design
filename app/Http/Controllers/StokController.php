<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockRecord;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = Session::get('active_branch_id', $user->branch_id);

        $query = StockRecord::with(['user', 'branch'])
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId));

        if ($request->filled('produk')) {
            $query->where('produk', $request->produk);
        }
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $stockRecords = $query->latest('tanggal')->latest('id')->paginate(15);
        $products = Product::active()->get();

        return view('stok.index', compact('stockRecords', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'tipe'    => 'required|in:masuk,keluar,opname,retur',
            'produk'  => 'required|string|max:100',
            'jumlah'  => 'required|integer|min:1',
            'satuan'  => 'required|string|max:20',
        ]);

        $user = Auth::user();
        $branchId = Session::get('active_branch_id', $user->branch_id);

        $stockRecord = StockRecord::create([
            'user_id'   => $user->id,
            'branch_id' => $branchId,
            'tanggal'   => $validated['tanggal'],
            'tipe'      => $validated['tipe'],
            'produk'    => $validated['produk'],
            'jumlah'    => $validated['jumlah'],
            'satuan'    => $validated['satuan'],
        ]);

        ActivityLogService::log(
            'add_stock',
            'stok',
            "Catatan stok '{$stockRecord->produk}' ({$stockRecord->tipe} {$stockRecord->jumlah} {$stockRecord->satuan}) ditambahkan",
            $stockRecord->id
        );

        return back()->with('success', 'Catatan stok berhasil ditambahkan.');
    }

    public function destroy(StockRecord $stock)
    {
        $info = "{$stock->produk} ({$stock->tipe} {$stock->jumlah} {$stock->satuan})";
        $id = $stock->id;

        $stock->delete();

        ActivityLogService::log('delete_stock', 'stok', "Catatan stok '{$info}' dihapus", $id);

        return back()->with('success', 'Catatan stok berhasil dihapus.');
    }
}
