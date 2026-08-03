<?php

namespace App\Http\Controllers;

use App\Models\Umkm;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Umkm::with('category')
            ->withCount('menus')
            ->where('is_featured', true)
            ->latest('id')
            ->take(8)
            ->get();

        return view('home', compact('featured'));
    }
}
