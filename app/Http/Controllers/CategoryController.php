<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->ordered()->get();
        return view('kategori.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'emoji'     => 'nullable|string|max:10',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'urutan'    => 'nullable|integer',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'foto.image'    => 'File harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if (!isset($validated['urutan'])) {
            $validated['urutan'] = Category::max('urutan') + 1;
        }

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'cat_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $validated['foto'] = $filename;
        }

        $category = Category::create($validated);

        ActivityLogService::log('create_category', 'kategori', "Kategori '{$category->nama}' ditambahkan", $category->id);

        return back()->with('success', "Kategori '{$category->nama}' berhasil ditambahkan.");
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'emoji'     => 'nullable|string|max:10',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'urutan'    => 'nullable|integer',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.max'      => 'Ukuran foto maksimal 3 MB.',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($category->foto && File::exists(public_path('uploads/categories/' . $category->foto))) {
                File::delete(public_path('uploads/categories/' . $category->foto));
            }

            $file = $request->file('foto');
            $filename = 'cat_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/categories'), $filename);
            $validated['foto'] = $filename;
        }

        $category->update($validated);

        ActivityLogService::log('update_category', 'kategori', "Kategori '{$category->nama}' diperbarui", $category->id);

        return back()->with('success', "Kategori '{$category->nama}' berhasil diperbarui.");
    }

    public function destroy(Category $category)
    {
        $nama = $category->nama;
        $id = $category->id;

        if ($category->foto && File::exists(public_path('uploads/categories/' . $category->foto))) {
            File::delete(public_path('uploads/categories/' . $category->foto));
        }

        $category->delete();

        ActivityLogService::log('delete_category', 'kategori', "Kategori '{$nama}' dihapus", $id);

        return back()->with('success', "Kategori '{$nama}' berhasil dihapus.");
    }

    public function toggleActive(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();

        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLogService::log('toggle_category', 'kategori', "Kategori '{$category->nama}' {$status}", $category->id);

        return back()->with('success', "Kategori '{$category->nama}' berhasil {$status}.");
    }
}
