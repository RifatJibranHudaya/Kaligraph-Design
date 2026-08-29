<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Product::ordered()->get();
        return view('produk.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'harga_min'   => 'required|numeric|min:0',
            'harga_max'   => 'nullable|numeric|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'urutan'      => 'nullable|integer',
        ], [
            'nama.required'      => 'Nama produk wajib diisi.',
            'harga_min.required' => 'Harga minimum (mulai dari) wajib diisi.',
            'foto.image'         => 'File yang diupload harus berupa gambar (JPG, PNG, WEBP, SVG).',
            'foto.max'           => 'Ukuran foto maksimal 3 MB.',
        ]);

        if (!isset($validated['urutan'])) {
            $validated['urutan'] = Product::max('urutan') + 1;
        }

        $validated['harga_default'] = $validated['harga_min'];
        $validated['is_active'] = $request->has('is_active');

        // Handle Photo Upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'prod_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $validated['foto'] = $filename;
        }

        $product = Product::create($validated);

        ActivityLogService::log('create_product', 'produk', "Produk '{$product->nama}' ditambahkan", $product->id);

        return back()->with('success', "Produk '{$product->nama}' berhasil ditambahkan.");
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama'        => 'required|string|max:100',
            'harga_min'   => 'required|numeric|min:0',
            'harga_max'   => 'nullable|numeric|min:0',
            'deskripsi'   => 'nullable|string',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'urutan'      => 'nullable|integer',
        ], [
            'nama.required'      => 'Nama produk wajib diisi.',
            'harga_min.required' => 'Harga minimum wajib diisi.',
            'foto.image'         => 'File yang diupload harus berupa gambar.',
            'foto.max'           => 'Ukuran foto maksimal 3 MB.',
        ]);

        $validated['harga_default'] = $validated['harga_min'];
        $validated['is_active'] = $request->has('is_active');

        // Handle Photo Upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($product->foto && File::exists(public_path('uploads/products/' . $product->foto))) {
                File::delete(public_path('uploads/products/' . $product->foto));
            }

            $file = $request->file('foto');
            $filename = 'prod_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $validated['foto'] = $filename;
        }

        $product->update($validated);

        ActivityLogService::log('update_product', 'produk', "Produk '{$product->nama}' diperbarui", $product->id);

        return back()->with('success', "Produk '{$product->nama}' berhasil diperbarui.");
    }

    public function destroy(Product $product)
    {
        $nama = $product->nama;
        $id = $product->id;

        // Delete photo file if exists
        if ($product->foto && File::exists(public_path('uploads/products/' . $product->foto))) {
            File::delete(public_path('uploads/products/' . $product->foto));
        }

        $product->delete();

        ActivityLogService::log('delete_product', 'produk', "Produk '{$nama}' dihapus", $id);

        return back()->with('success', "Produk '{$nama}' berhasil dihapus.");
    }

    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLogService::log('toggle_product', 'produk', "Produk '{$product->nama}' {$status}", $product->id);

        return back()->with('success', "Produk '{$product->nama}' berhasil {$status}.");
    }
}
