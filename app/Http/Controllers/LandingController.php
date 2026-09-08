<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\HomeContent;
use App\Models\Portfolio;
use App\Models\Product;

class LandingController extends Controller
{
    public function index()
    {
        $homeContents = HomeContent::active()->ordered()->get()->groupBy('section');
        $branches = Branch::all();
        $categories = Category::active()->ordered()->withCount(['activeProducts as products_count'])->get();

        return view('landing', compact('homeContents', 'branches', 'categories'));
    }

    /**
     * Public catalog — all categories.
     */
    public function categories()
    {
        $categories = Category::active()->ordered()->withCount(['activeProducts as products_count'])->get();
        return view('katalog.kategori', compact('categories'));
    }

    /**
     * Public catalog — products by category.
     */
    public function productsByCategory(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->active()
            ->ordered()
            ->get();

        $categories = Category::active()->ordered()->get();

        return view('katalog.produk', compact('category', 'products', 'categories'));
    }

    /**
     * Public catalog — product detail.
     */
    public function productDetail(string $slug, Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->ordered()
            ->take(4)
            ->get();

        return view('katalog.detail', compact('product', 'relatedProducts'));
    }

    /**
     * Public portfolio page.
     */
    public function portfolio()
    {
        $portfolios = Portfolio::with('category')->active()->ordered()->get();
        $categories = Category::active()->ordered()->get();

        return view('portofolio', compact('portfolios', 'categories'));
    }
}
