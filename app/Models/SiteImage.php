<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SiteImage extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'path_gambar',
        'alt_text',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    public function defaultAssetPath(): ?string
    {
        $category = Str::lower(trim((string) $this->kategori));
        $title = Str::lower(trim((string) $this->judul));
        $order = (int) $this->urutan;

        $byTitle = [
            'hero slider|hero badminton 1' => 'images/Bulutangkis-9.jpeg',
            'hero slider|hero billiard' => 'images/Billiard.jpeg',
            'hero slider|hero badminton 2' => 'images/Bulutangkis-6.jpeg',
            'hero slider|hero badminton 3' => 'images/Bulutangkis-2.jpeg',
            'hero slider|hero billiard 2' => 'images/Billiard-2.jpeg',
            'hero slider|hero area duduk' => 'images/Kursi.jpeg',
            'badminton|lapangan badminton' => 'images/Bulutangkis-2.jpeg',
            'badminton|badminton indoor' => 'images/Bulutangkis-3.jpeg',
            'badminton|permainan badminton' => 'images/Bulutangkis-4.jpeg',
            'badminton|olahraga indoor' => 'images/Bulutangkis-5.jpeg',
            'billiard|billiard premium' => 'images/Billiard-1.jpeg',
            'billiard|meja billiard' => 'images/Billiard-2.jpeg',
            'billiard|ruang billiard' => 'images/Billiard-3.jpeg',
            'billiard|billiard lounge' => 'images/Billiard-4.jpeg',
            'pendukung|mushola' => 'images/Mushola-1.jpeg',
            'pendukung|area duduk' => 'images/Kursi.jpeg',
            'pendukung|toko' => 'images/Toko.jpeg',
            'pendukung|toilet' => 'images/Toilet.jpeg',
            'pendukung|parkiran' => 'images/Parkiran.jpeg',
            'pendukung|area parkir' => 'images/ParkiranAll.jpeg',
        ];

        $titleKey = $category . '|' . $title;
        if (isset($byTitle[$titleKey])) {
            return $byTitle[$titleKey];
        }

        $byCategoryAndOrder = [
            'hero slider' => [
                1 => 'images/Bulutangkis-9.jpeg',
                2 => 'images/Billiard.jpeg',
                3 => 'images/Bulutangkis-6.jpeg',
                4 => 'images/Bulutangkis-2.jpeg',
                5 => 'images/Billiard-2.jpeg',
                6 => 'images/Kursi.jpeg',
            ],
            'badminton' => [
                1 => 'images/Bulutangkis-2.jpeg',
                2 => 'images/Bulutangkis-3.jpeg',
                3 => 'images/Bulutangkis-4.jpeg',
                4 => 'images/Bulutangkis-5.jpeg',
            ],
            'billiard' => [
                1 => 'images/Billiard-1.jpeg',
                2 => 'images/Billiard-2.jpeg',
                3 => 'images/Billiard-3.jpeg',
                4 => 'images/Billiard-4.jpeg',
            ],
            'pendukung' => [
                1 => 'images/Mushola-1.jpeg',
                2 => 'images/Kursi.jpeg',
                3 => 'images/Toko.jpeg',
                4 => 'images/Toilet.jpeg',
                5 => 'images/Parkiran.jpeg',
                6 => 'images/ParkiranAll.jpeg',
            ],
        ];

        return $byCategoryAndOrder[$category][$order] ?? null;
    }

    public function isUsingDefaultAsset(): bool
    {
        $defaultPath = $this->defaultAssetPath();

        return $defaultPath !== null && $this->path_gambar === $defaultPath;
    }
}
