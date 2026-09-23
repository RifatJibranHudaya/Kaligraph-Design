<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::latest()->take(100)->get();
        
        return response()->view('sitemap.index', [
            'categories' => $categories,
            'products' => $products,
        ])->header('Content-Type', 'text/xml');
    }
}
