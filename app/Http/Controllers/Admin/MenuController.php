<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index(Umkm $umkm)
    {
        $menus = $umkm->menus()->latest('id')->paginate(12);

        return view('admin.menu.index', compact('umkm', 'menus'));
    }

    public function create(Umkm $umkm)
    {
        return view('admin.menu.create', compact('umkm'));
    }

    public function store(Request $request, Umkm $umkm)
    {
        $data = $this->validated($request);
        $data['umkm_id'] = $umkm->id;
        $data['photo_path'] = $this->handlePhoto($request);

        Menu::create($data);

        return redirect()
            ->route('admin.umkm.menu.index', $umkm)
            ->with('status', 'Menu berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm, Menu $menu)
    {
        $this->ensureBelongsTo($umkm, $menu);

        return view('admin.menu.edit', compact('umkm', 'menu'));
    }

    public function update(Request $request, Umkm $umkm, Menu $menu)
    {
        $this->ensureBelongsTo($umkm, $menu);

        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            if ($menu->photo_path) {
                Storage::disk('public')->delete($menu->photo_path);
            }
            $data['photo_path'] = $this->handlePhoto($request);
        }

        $menu->update($data);

        return redirect()
            ->route('admin.umkm.menu.index', $umkm)
            ->with('status', 'Menu berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm, Menu $menu)
    {
        $this->ensureBelongsTo($umkm, $menu);

        if ($menu->photo_path) {
            Storage::disk('public')->delete($menu->photo_path);
        }
        $menu->delete();

        return redirect()
            ->route('admin.umkm.menu.index', $umkm)
            ->with('status', 'Menu berhasil dihapus.');
    }

    private function ensureBelongsTo(Umkm $umkm, Menu $menu): void
    {
        abort_unless($menu->umkm_id === $umkm->id, 404);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['is_available'] = $request->boolean('is_available');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['photo']);

        return $data;
    }

    private function handlePhoto(Request $request): ?string
    {
        return $request->hasFile('photo')
            ? $request->file('photo')->store('menu', 'public')
            : null;
    }
}
