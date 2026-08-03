<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Umkm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index()
    {
        $umkms = Umkm::with('category')
            ->withCount([
                'menus',
                'contactEvents as kontak_30' => fn (Builder $q) => $q->lastDays(30),
            ])
            ->latest('id')
            ->paginate(12);

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
        foreach ($umkm->menus as $menu) {
            if ($menu->photo_path) {
                Storage::disk('public')->delete($menu->photo_path);
            }
        }

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
            'price_range' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'whatsapp' => ['required', 'string', 'max:20'],
            'shopee_url' => ['nullable', 'url', 'max:255'],
            'pastel_bg' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:4096'],
            'opening_time' => ['nullable', 'date_format:H:i', 'required_with:closing_time'],
            'closing_time' => ['nullable', 'date_format:H:i', 'required_with:opening_time'],
            'closed_days' => ['nullable', 'array'],
            'closed_days.*' => ['integer', 'between:1,7'],
        ], [
            'opening_time.required_with' => 'Jam buka wajib diisi bila jam tutup diisi.',
            'closing_time.required_with' => 'Jam tutup wajib diisi bila jam buka diisi.',
        ]);

        $data['kelurahan'] = 'Tambaksari';

        // Hari libur tanpa jam buka tidak punya arti, jadi ikut dikosongkan.
        $data['closed_days'] = filled($data['opening_time'] ?? null)
            ? array_values(array_unique(array_map('intval', $data['closed_days'] ?? [])))
            : null;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_bestseller'] = $request->boolean('is_bestseller');
        // Field ini hanya dikirim oleh form admin, jadi jangan asumsikan selalu ada.
        $data['pastel_bg'] = ($data['pastel_bg'] ?? null) ?: 'linear-gradient(135deg,#EDE9FE,#F5F0FF)';
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
