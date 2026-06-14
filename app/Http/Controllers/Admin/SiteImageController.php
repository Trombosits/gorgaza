<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiteImageController extends Controller
{
    public function index()
    {
        $images = SiteImage::orderBy('kategori')->orderBy('urutan')->orderBy('judul')->get();
        return view('Admin.site_images.index', compact('images'));
    }

    public function create()
    {
        return view('Admin.site_images.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        unset($data['gambar'], $data['hapus_gambar']);

        $data['urutan'] = $data['urutan'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $data['path_gambar'] = $this->storeImage($request);

        SiteImage::create($data);

        return redirect()->route('admin.site-images.index')->with('success', 'Gambar landing berhasil ditambahkan.');
    }

    public function edit(SiteImage $siteImage)
    {
        return view('Admin.site_images.edit', compact('siteImage'));
    }

    public function update(Request $request, SiteImage $siteImage)
    {
        $data = $this->validatedData($request, true);
        unset($data['gambar'], $data['hapus_gambar']);

        $data['urutan'] = $data['urutan'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('gambar')) {
            $this->deleteImage($siteImage->path_gambar);
            $data['path_gambar'] = $this->storeImage($request);
        } elseif ($request->boolean('hapus_gambar')) {
            $defaultPath = $siteImage->defaultAssetPath();

            if ($defaultPath) {
                $this->deleteImage($siteImage->path_gambar);
                $data['path_gambar'] = $defaultPath;
            }
        }

        $siteImage->update($data);

        return redirect()->route('admin.site-images.index')->with('success', 'Gambar landing berhasil diperbarui.');
    }

    public function destroy(SiteImage $siteImage)
    {
        $this->deleteImage($siteImage->path_gambar);
        $siteImage->delete();

        return redirect()->route('admin.site-images.index')->with('success', 'Gambar landing berhasil dihapus.');
    }

    private function validatedData(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'judul' => 'required|string|max:120',
            'kategori' => 'required|string|max:80',
            'alt_text' => 'nullable|string|max:160',
            'urutan' => 'nullable|integer|min:0',
            'gambar' => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'hapus_gambar' => 'nullable|boolean',
        ]);
    }

    private function storeImage(Request $request): string
    {
        $directory = public_path('images/site-images');
        File::ensureDirectoryExists($directory);

        $file = $request->file('gambar');
        $filename = 'landing-' . time() . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'images/site-images/' . $filename;
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);
        if (File::exists($fullPath) && str_contains($path, 'images/site-images/')) {
            File::delete($fullPath);
        }
    }
}
