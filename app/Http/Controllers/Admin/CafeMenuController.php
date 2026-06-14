<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CafeMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CafeMenuController extends Controller
{
    public function index()
    {
        $menus = CafeMenu::orderBy('kategori')->orderBy('urutan')->orderBy('nama_menu')->get();
        return view('Admin.cafe_menus.index', compact('menus'));
    }

    public function create()
    {
        return view('Admin.cafe_menus.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['urutan'] = $data['urutan'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['gambar'] = $this->storeImage($request);

        CafeMenu::create($data);

        return redirect()->route('admin.cafe-menus.index')->with('success', 'Menu kafe berhasil ditambahkan.');
    }

    public function edit(CafeMenu $cafeMenu)
    {
        return view('Admin.cafe_menus.edit', compact('cafeMenu'));
    }

    public function update(Request $request, CafeMenu $cafeMenu)
    {
        $data = $this->validatedData($request);
        $data['urutan'] = $data['urutan'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->boolean('hapus_gambar')) {
            $this->deleteImage($cafeMenu->gambar);
            $data['gambar'] = null;
        }

        if ($request->hasFile('gambar')) {
            $this->deleteImage($cafeMenu->gambar);
            $data['gambar'] = $this->storeImage($request);
        }

        $cafeMenu->update($data);

        return redirect()->route('admin.cafe-menus.index')->with('success', 'Menu kafe berhasil diperbarui.');
    }

    public function destroy(CafeMenu $cafeMenu)
    {
        $this->deleteImage($cafeMenu->gambar);
        $cafeMenu->delete();

        return redirect()->route('admin.cafe-menus.index')->with('success', 'Menu kafe berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nama_menu' => 'required|string|max:120',
            'kategori' => 'required|string|max:80',
            'harga' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }

    private function storeImage(Request $request): ?string
    {
        if (!$request->hasFile('gambar')) {
            return null;
        }

        $directory = public_path('images/cafe-menus');
        File::ensureDirectoryExists($directory);

        $file = $request->file('gambar');
        $filename = 'menu-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'images/cafe-menus/' . $filename;
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);
        if (File::exists($fullPath) && str_contains($path, 'images/cafe-menus/')) {
            File::delete($fullPath);
        }
    }
}
