<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id')->get();

        $featured = Umkm::with('category')
            ->where('is_featured', true)
            ->latest('id')
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featured'));
    }
}
