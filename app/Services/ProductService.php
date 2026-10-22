<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    /**
     * Create a product (custom_wa or ecommerce).
     */
    public static function createProduct(array $data, ?UploadedFile $file = null): Product
    {
        if (!isset($data['urutan'])) {
            $data['urutan'] = Product::max('urutan') + 1;
        }

        $data['tipe_produk'] = $data['tipe_produk'] ?? Product::TIPE_CUSTOM_WA;
        $data['harga_default'] = (int) ($data['harga_min'] ?? 0);

        // Auto-generate SKU for ecommerce if left empty
        if ($data['tipe_produk'] === Product::TIPE_ECOMMERCE && empty($data['sku'])) {
            $data['sku'] = 'EC-' . strtoupper(Str::random(6));
        }

        // Handle photo upload
        if ($file) {
            $filename = 'prod_' . Str::uuid() . '.webp';
            self::compressAndStore($file->getRealPath(), 'products/' . $filename);
            $data['foto'] = $filename;
        }

        $product = Product::create($data);

        ActivityLogService::log(
            'create_product',
            'produk',
            "Produk '{$product->nama}' (" . $product->tipe_label . ") ditambahkan",
            $product->id
        );

        return $product;
    }

    /**
     * Update product details.
     */
    public static function updateProduct(Product $product, array $data, ?UploadedFile $file = null): Product
    {
        $data['tipe_produk'] = $data['tipe_produk'] ?? $product->tipe_produk;
        $data['harga_default'] = (int) ($data['harga_min'] ?? 0);

        if ($file) {
            // Delete old photo
            if ($product->foto) {
                Storage::disk('public')->delete('products/' . $product->foto);
                $legacy = public_path('uploads/products/' . $product->foto);
                if (file_exists($legacy)) {
                    @unlink($legacy);
                }
            }

            $filename = 'prod_' . Str::uuid() . '.webp';
            self::compressAndStore($file->getRealPath(), 'products/' . $filename);
            $data['foto'] = $filename;
        }

        $product->update($data);

        ActivityLogService::log(
            'update_product',
            'produk',
            "Produk '{$product->nama}' (" . $product->tipe_label . ") diperbarui",
            $product->id
        );

        return $product;
    }

    /**
     * Adjust stock for e-commerce products.
     */
    public static function adjustStock(Product $product, int $newStock, ?string $reason = null): Product
    {
        $oldStock = $product->stock;
        $product->stock = max(0, $newStock);
        $product->save();

        $detail = "Penyesuaian stok produk '{$product->nama}' dari {$oldStock} menjadi {$product->stock}";
        if ($reason) {
            $detail .= " (Alasan: {$reason})";
        }

        ActivityLogService::log('adjust_stock', 'produk', $detail, $product->id);

        return $product;
    }

    /**
     * Delete product & cleanup storage.
     */
    public static function deleteProduct(Product $product): void
    {
        $nama = $product->nama;
        $id = $product->id;

        if ($product->foto) {
            Storage::disk('public')->delete('products/' . $product->foto);
            $legacy = public_path('uploads/products/' . $product->foto);
            if (file_exists($legacy)) {
                @unlink($legacy);
            }
        }

        $product->delete();

        ActivityLogService::log('delete_product', 'produk', "Produk '{$nama}' dihapus", $id);
    }

    /**
     * Compress image to WebP/JPEG for storage.
     */
    public static function compressAndStore(string $sourcePath, string $storagePath, int $maxKB = 1024): void
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
            if (function_exists('imagewebp') && str_ends_with($storagePath, '.webp')) {
                imagewebp($canvas, null, $quality);
            } else {
                imagejpeg($canvas, null, $quality);
            }
            $output = ob_get_clean();
            $quality -= 5;
        } while (strlen($output) > $maxBytes && $quality >= 20);

        imagedestroy($canvas);

        Storage::disk('public')->put($storagePath, $output);
    }
}
