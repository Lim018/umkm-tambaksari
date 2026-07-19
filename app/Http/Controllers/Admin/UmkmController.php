<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::with('category')->latest('id')->paginate(12);
        return view('admin.umkm.index', compact('umkms'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.umkm.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['photo_path'] = $this->handlePhoto($request);

        Umkm::create($data);

        return redirect()->route('admin.umkm.index')->with('status', 'UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.umkm.edit', compact('umkm', 'categories'));
    }

    public function update(Request $request, Umkm $umkm)
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            if ($umkm->photo_path) {
                Storage::disk('public')->delete($umkm->photo_path);
            }
            $data['photo_path'] = $this->handlePhoto($request);
        }

        $umkm->update($data);

        return redirect()->route('admin.umkm.index')->with('status', 'UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm)
    {
        if ($umkm->photo_path) {
            Storage::disk('public')->delete($umkm->photo_path);
        }
        $umkm->delete();

        return redirect()->route('admin.umkm.index')->with('status', 'UMKM berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'kelurahan' => ['required', 'string', 'max:255'],
            'price_range' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'shopee_url' => ['nullable', 'url', 'max:255'],
            'pastel_bg' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_bestseller'] = $request->boolean('is_bestseller');
        $data['pastel_bg'] = $data['pastel_bg'] ?: 'linear-gradient(135deg,#EDE9FE,#F5F0FF)';
        unset($data['photo']);

        return $data;
    }

    private function handlePhoto(Request $request): ?string
    {
        return $request->hasFile('photo')
            ? $request->file('photo')->store('umkm', 'public')
            : null;
    }
}
