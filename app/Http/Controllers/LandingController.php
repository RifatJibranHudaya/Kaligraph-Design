<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\HomeContent;
use App\Models\Product;

class LandingController extends Controller
{
    public function index()
    {
        $homeContents = HomeContent::active()->ordered()->get()->groupBy('section');
        $branches = Branch::all();
        $products = Product::active()->ordered()->take(6)->get();

        return view('landing', compact('homeContents', 'branches', 'products'));
    }
}
