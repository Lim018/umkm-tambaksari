<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $kategori = $request->query('kategori');
        $kelurahan = $request->query('kelurahan');
        $sort = $request->query('sort', 'baru');

        $umkms = Umkm::with('category')
            ->withCount('menus')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('kelurahan', 'like', "%{$q}%")
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('menus', fn ($m) => $m->where('name', 'like', "%{$q}%"));
                });
            })
            ->when($kategori, fn ($query) => $query->whereHas('category', fn ($c) => $c->where('slug', $kategori)))
            ->when($kelurahan, fn ($query) => $query->where('kelurahan', $kelurahan))
            ->when($sort === 'terlaris', fn ($query) => $query->where('is_bestseller', true))
            ->latest('id')
            ->paginate(8)
            ->withQueryString();

        $categories = Category::orderBy('id')->get();
        $kelurahans = Umkm::query()->distinct()->orderBy('kelurahan')->pluck('kelurahan');

        return view('catalog.index', compact('umkms', 'categories', 'kelurahans', 'q', 'kategori', 'kelurahan', 'sort'));
    }

    public function show(Umkm $umkm)
    {
        $umkm->load(['category', 'menus']);

        return view('catalog.show', compact('umkm'));
    }
}
