<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Umkm;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'umkm' => Umkm::count(),
            'kategori' => Category::count(),
            'featured' => Umkm::where('is_featured', true)->count(),
            'bestseller' => Umkm::where('is_bestseller', true)->count(),
            'menu' => Menu::count(),
        ];

        $recent = Umkm::with('category')->latest('id')->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
