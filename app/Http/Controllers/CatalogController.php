<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactEvent;
use App\Models\Umkm;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $kategori = $request->query('kategori');
        $sort = $request->query('sort', 'baru');

        $umkms = Umkm::with('category')
            ->withCount('menus')
            ->withPopularity()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('menus', fn ($m) => $m->where('name', 'like', "%{$q}%"));
                });
            })
            ->when($kategori, fn ($query) => $query->whereHas('category', fn ($c) => $c->where('slug', $kategori)))
            ->when($sort === 'terlaris', fn ($query) => $query->where('is_bestseller', true))
            ->when($sort === 'populer', fn ($query) => $query->orderByDesc('kontak_populer'))
            ->latest('id')
            ->paginate(8)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('catalog.index', compact('umkms', 'categories', 'q', 'kategori', 'sort'));
    }

    public function show(Umkm $umkm)
    {
        $umkm->load(['category', 'menus' => fn ($menus) => $menus->withPopularity()])
            ->loadCount([
                'contactEvents as kontak_populer' => fn ($q) => $q->lastDays(ContactEvent::POPULARITY_DAYS),
            ]);

        return view('catalog.show', compact('umkm'));
    }
}
