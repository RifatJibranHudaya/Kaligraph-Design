<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('category')->ordered()->get();
        $categories = Category::ordered()->get();
        return view('portfolio.index', compact('portfolios', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'deskripsi'   => 'nullable|string',
            'client'      => 'nullable|string|max:150',
            'lokasi'      => 'nullable|string|max:150',
            'tahun'       => 'nullable|string|max:10',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'urutan'      => 'nullable|integer',
        ], [
            'nama.required' => 'Nama portofolio wajib diisi.',
            'foto.image'    => 'File yang diupload harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',
        ]);

        if (!isset($validated['urutan'])) {
            $validated['urutan'] = Portfolio::max('urutan') + 1;
        }

        $validated['is_active'] = $request->has('is_active');

        // Handle Photo Upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'port_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/portfolios'), $filename);
            $validated['foto'] = $filename;
        }

        $portfolio = Portfolio::create($validated);

        ActivityLogService::log('create_portfolio', 'portfolio', "Portofolio '{$portfolio->nama}' ditambahkan", $portfolio->id);

        return back()->with('success', "Portofolio '{$portfolio->nama}' berhasil ditambahkan.");
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'deskripsi'   => 'nullable|string',
            'client'      => 'nullable|string|max:150',
            'lokasi'      => 'nullable|string|max:150',
            'tahun'       => 'nullable|string|max:10',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'urutan'      => 'nullable|integer',
        ], [
            'nama.required' => 'Nama portofolio wajib diisi.',
            'foto.image'    => 'File yang diupload harus berupa gambar.',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Handle Photo Upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($portfolio->foto && File::exists(public_path('uploads/portfolios/' . $portfolio->foto))) {
                File::delete(public_path('uploads/portfolios/' . $portfolio->foto));
            }

            $file = $request->file('foto');
            $filename = 'port_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/portfolios'), $filename);
            $validated['foto'] = $filename;
        }

        $portfolio->update($validated);

        ActivityLogService::log('update_portfolio', 'portfolio', "Portofolio '{$portfolio->nama}' diperbarui", $portfolio->id);

        return back()->with('success', "Portofolio '{$portfolio->nama}' berhasil diperbarui.");
    }

    public function destroy(Portfolio $portfolio)
    {
        $nama = $portfolio->nama;
        $id = $portfolio->id;

        // Delete photo file if exists
        if ($portfolio->foto && File::exists(public_path('uploads/portfolios/' . $portfolio->foto))) {
            File::delete(public_path('uploads/portfolios/' . $portfolio->foto));
        }

        $portfolio->delete();

        ActivityLogService::log('delete_portfolio', 'portfolio', "Portofolio '{$nama}' dihapus", $id);

        return back()->with('success', "Portofolio '{$nama}' berhasil dihapus.");
    }

    public function toggleActive(Portfolio $portfolio)
    {
        $portfolio->is_active = !$portfolio->is_active;
        $portfolio->save();

        $status = $portfolio->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLogService::log('toggle_portfolio', 'portfolio', "Portofolio '{$portfolio->nama}' {$status}", $portfolio->id);

        return back()->with('success', "Portofolio '{$portfolio->nama}' berhasil {$status}.");
    }
}
