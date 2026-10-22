<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Category;
use App\Models\Portfolio;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('category')->ordered()->get();
        $categories = Category::ordered()->get();
        return view('portfolio.index', compact('portfolios', 'categories'));
    }

    public function store(StorePortfolioRequest $request)
    {
        $validated = $request->validated();

        if (!isset($validated['urutan'])) {
            $validated['urutan'] = Portfolio::max('urutan') + 1;
        }

        $validated['is_active'] = $request->has('is_active');

        // Secure Photo Upload via Storage facade with UUID filename
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'port_' . Str::uuid() . '.webp';
            $this->compressAndStore($file->getRealPath(), 'portfolios/' . $filename);
            $validated['foto'] = $filename;
        }

        $portfolio = Portfolio::create($validated);

        ActivityLogService::log('create_portfolio', 'portfolio', "Portofolio '{$portfolio->nama}' ditambahkan", $portfolio->id);

        return back()->with('success', "Portofolio '{$portfolio->nama}' berhasil ditambahkan.");
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio)
    {
        $validated = $request->validated();

        $validated['is_active'] = $request->has('is_active');

        // Secure Photo Upload via Storage facade with UUID filename
        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($portfolio->foto) {
                Storage::disk('public')->delete('portfolios/' . $portfolio->foto);
                $legacyPath = public_path('uploads/portfolios/' . $portfolio->foto);
                if (file_exists($legacyPath)) {
                    @unlink($legacyPath);
                }
            }

            $file = $request->file('foto');
            $filename = 'port_' . Str::uuid() . '.webp';
            $this->compressAndStore($file->getRealPath(), 'portfolios/' . $filename);
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

        if ($portfolio->foto) {
            Storage::disk('public')->delete('portfolios/' . $portfolio->foto);
            $legacyPath = public_path('uploads/portfolios/' . $portfolio->foto);
            if (file_exists($legacyPath)) {
                @unlink($legacyPath);
            }
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
