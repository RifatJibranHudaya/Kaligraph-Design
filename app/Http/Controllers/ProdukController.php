<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\ActivityLogService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display product catalog with dual sub-module filtering:
     * - 'custom_wa': Pesanan kustom via WhatsApp
     * - 'ecommerce': E-commerce Ready Stock (WooCommerce style)
     */
    public function index(Request $request)
    {
        $currentTab = $request->get('tab', 'semua');

        $query = Product::with('category')->ordered();

        if ($currentTab === 'custom_wa') {
            $query->customWa();
        } elseif ($currentTab === 'ecommerce') {
            $query->ecommerce();
        }

        $products = $query->get();
        $categories = Category::ordered()->get();

        $counts = [
            'semua'       => Product::count(),
            'custom_wa'   => Product::customWa()->count(),
            'ecommerce'   => Product::ecommerce()->count(),
            'out_of_stock'=> Product::ecommerce()->where('stock', '<=', 0)->count(),
        ];

        return view('produk.index', compact('products', 'categories', 'currentTab', 'counts'));
    }

    /**
     * Store new product in either sub-module (custom_wa or ecommerce).
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');

        $product = ProductService::createProduct($validated, $request->file('foto'));

        $submodul = $product->isEcommerce() ? 'E-Commerce' : 'Pesanan Kustom (WA)';
        return back()->with('success', "Produk '{$product->nama}' berhasil ditambahkan ke sub-modul {$submodul}.");
    }

    /**
     * Update existing product.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->has('is_active');

        $product = ProductService::updateProduct($product, $validated, $request->file('foto'));

        return back()->with('success', "Produk '{$product->nama}' berhasil diperbarui.");
    }

    /**
     * Delete product.
     */
    public function destroy(Product $product)
    {
        $nama = $product->nama;
        ProductService::deleteProduct($product);

        return back()->with('success', "Produk '{$nama}' berhasil dihapus.");
    }

    /**
     * Toggle active visibility on public website & catalog.
     */
    public function toggleActive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLogService::log('toggle_product', 'produk', "Produk '{$product->nama}' {$status}", $product->id);

        return back()->with('success', "Produk '{$product->nama}' berhasil {$status}.");
    }

    /**
     * Quick adjust stock for e-commerce product.
     */
    public function adjustStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'stock'  => 'required|integer|min:0|max:999999',
            'reason' => 'nullable|string|max:255',
        ]);

        ProductService::adjustStock($product, $validated['stock'], $validated['reason'] ?? null);

        return back()->with('success', "Stok produk '{$product->nama}' berhasil disesuaikan menjadi {$product->stock}.");
    }
}
