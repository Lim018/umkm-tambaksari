<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('umkms')->orderBy('id')->paginate(20);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()->route('admin.kategori.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $kategori)
    {
        return view('admin.category.edit', ['category' => $kategori]);
    }

    public function update(Request $request, Category $kategori)
    {
        $data = $this->validated($request, $kategori->id);
        $data['slug'] = Str::slug($data['name']);

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('status', 'Kategori berhasil dihapus.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($ignoreId)],
            'icon' => ['nullable', 'string', 'max:16'],
            'accent_color' => ['required', 'string', 'max:9'],
            'tint' => ['required', 'string', 'max:9'],
        ]);
    }
}
