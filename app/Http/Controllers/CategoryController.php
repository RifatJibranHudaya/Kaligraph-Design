<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->ordered()->get();
        return view('kategori.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['nama']);

        if (!isset($validated['urutan'])) {
            $validated['urutan'] = Category::max('urutan') + 1;
        }

        $validated['is_active'] = $request->has('is_active');

        // Secure Photo Upload via Storage facade with UUID filename
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'cat_' . Str::uuid() . '.webp';
            $this->compressAndStore($file->getRealPath(), 'categories/' . $filename);
            $validated['foto'] = $filename;
        }

        $category = Category::create($validated);

        ActivityLogService::log('create_category', 'kategori', "Kategori '{$category->nama}' ditambahkan", $category->id);

        return back()->with('success', "Kategori '{$category->nama}' berhasil ditambahkan.");
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['nama']);
        $validated['is_active'] = $request->has('is_active');

        // Secure Photo Upload via Storage facade with UUID filename
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($category->foto) {
                Storage::disk('public')->delete('categories/' . $category->foto);
                $legacyPath = public_path('uploads/categories/' . $category->foto);
                if (file_exists($legacyPath)) {
                    @unlink($legacyPath);
                }
            }

            $file = $request->file('foto');
            $filename = 'cat_' . Str::uuid() . '.webp';
            $this->compressAndStore($file->getRealPath(), 'categories/' . $filename);
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

        if ($category->foto) {
            Storage::disk('public')->delete('categories/' . $category->foto);
            $legacyPath = public_path('uploads/categories/' . $category->foto);
            if (file_exists($legacyPath)) {
                @unlink($legacyPath);
            }
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

    /**
     * Compress image and store via Storage facade.
     */
    private function compressAndStore(string $sourcePath, string $storagePath, int $maxKB = 1024): void
    {
        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo) {
            Storage::disk('public')->put($storagePath, file_get_contents($sourcePath));
            return;
        }

        $mime = $imageInfo['mime'];
        $img = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($sourcePath),
            'image/png'               => @imagecreatefrompng($sourcePath),
            'image/webp'              => @imagecreatefromwebp($sourcePath),
            default                   => false,
        };

        if (!$img) {
            Storage::disk('public')->put($storagePath, file_get_contents($sourcePath));
            return;
        }

        $width  = imagesx($img);
        $height = imagesy($img);
        $canvas = imagecreatetruecolor($width, $height);
        $white  = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopy($canvas, $img, 0, 0, 0, 0, $width, $height);
        imagedestroy($img);

        $maxBytes = $maxKB * 1024;
        $quality  = 85;

        do {
            ob_start();
            imagejpeg($canvas, null, $quality);
            $output = ob_get_clean();
            $quality -= 5;
        } while (strlen($output) > $maxBytes && $quality >= 20);

        imagedestroy($canvas);

        Storage::disk('public')->put($storagePath, $output);
    }
}
