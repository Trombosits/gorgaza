<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>GOR GAZA - Pemesanan Lapangan & Billiard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Poppins:wght@600;700;800;900&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  </head>
  <body class="frontend-page">
    @php
      $cafeMenus = $cafeMenus ?? collect();
      $siteImages = $siteImages ?? collect();

      $fallbackImages = function (array $items) {
          return collect($items)->map(fn ($item) => (object) $item);
      };

      $heroImages = ($siteImages->get('Hero Slider') ?? collect());
      if ($heroImages->isEmpty()) {
          $heroImages = $fallbackImages([
              ['path_gambar' => 'images/Bulutangkis-9.jpeg', 'alt_text' => 'Lapangan badminton GOR GAZA'],
              ['path_gambar' => 'images/Billiard.jpeg', 'alt_text' => 'Meja billiard GOR GAZA'],
              ['path_gambar' => 'images/Bulutangkis-6.jpeg', 'alt_text' => 'Suasana badminton GOR GAZA'],
              ['path_gambar' => 'images/Bulutangkis-2.jpeg', 'alt_text' => 'Lapangan badminton indoor'],
              ['path_gambar' => 'images/Billiard-2.jpeg', 'alt_text' => 'Area billiard GOR GAZA'],
              ['path_gambar' => 'images/Kursi.jpeg', 'alt_text' => 'Area duduk GOR GAZA'],
          ]);
      }

      $galleryImages = function (string $category, array $fallback) use ($siteImages, $fallbackImages) {
          $items = $siteImages->get($category) ?? collect();
          return $items->isNotEmpty() ? $items : $fallbackImages($fallback);
      };

      $formatMenuPrice = function ($harga) {
          return is_null($harga) ? 'TBD' : 'Rp' . number_format($harga, 0, ',', '.');
      };
    @endphp
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top app-navbar">
      <div class="container">
        <a class="navbar-brand brand-mark" href="/">
          <img src="{{ asset('images/logo-gorgaza.png') }}" alt="GOR GAZA" class="navbar-logo-img">
          <span>GOR GAZA</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
  <ul class="navbar-nav ms-auto me-3">
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}#hero">Beranda</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}#fasilitas">Fasilitas</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}#harga">Harga</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}#menu-kafe">Menu Kafe</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}#jadwal">Jadwal</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}#lokasi">Lokasi</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('/') }}#kritik-saran">Kritik & Saran</a>
    </li>
  </ul>
</div>

          <div class="nav-auth d-flex gap-2">
            @if(session('auth_user.role') === 'admin')
              <a class="btn btn-outline-light rounded-pill px-3" href="/admin/dashboard">Admin</a>
              <form action="/logout" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger rounded-pill px-3">Keluar</button>
              </form>
            @elseif(session('auth_user'))
              <a class="btn btn-outline-light rounded-pill px-3" href="/booking">Pemesanan</a>
              <a class="btn btn-warning rounded-pill px-3 fw-bold" href="/booking-history">Riwayat</a>
              <form action="/logout" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger rounded-pill px-3">Keluar</button>
              </form>
            @else
              <a class="btn btn-book" href="/login">Masuk / Daftar</a>
            @endif
          </div>
        </div>
      </div>
    </nav>

    <section class="hero hero-slider" id="hero" aria-label="Beranda GOR GAZA">
      <div class="hero-slide-layer" aria-hidden="true">
        @foreach($heroImages as $index => $image)
          <div class="hero-slide {{ $index === 0 ? 'is-active' : '' }}" style="background-image: url('{{ asset($image->path_gambar) }}')"></div>
        @endforeach
      </div>
      <div class="hero-overlay"></div>
      <div class="container position-relative">
        <div class="row align-items-center g-5">
          <div class="col-lg-8 hero-copy">
            <h1>Pemesanan <span>Lapangan</span> & <span>Billiard</span> Jadi Lebih Mudah</h1>
            <p>
              GOR GAZA menyediakan lapangan badminton, meja billiard premium, dan area santai dalam satu tempat. Cek jadwal, pilih sesi, lalu booking tanpa antre.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
              <a href="/booking" class="btn btn-warning btn-lg hero-cta">
                <i class="fas fa-calendar-check me-2"></i>Pesan Sekarang
              </a>
              <a href="#harga" class="btn btn-outline-light btn-lg hero-cta-outline">
                <i class="fa-solid fa-tags me-2"></i>Lihat Harga
              </a>
            </div>
            <div class="hero-stats mt-5">
              <div>
                <strong>Badminton & Billiard</strong>
                <span>Pemesanan online</span>
              </div>
              <div>
                <strong>{{ \Carbon\Carbon::parse($setting->jam_buka)->format('H:i') }}
                      -
                      {{ \Carbon\Carbon::parse($setting->jam_tutup)->format('H:i') }}</strong>
                <span>Jam operasional</span>
              </div>
              <div>
                <strong>Khusus QRIS</strong>
                <span>Pembayaran lebih aman</span>
              </div>
            </div>
            <div class="hero-slider-indicators" aria-label="Indikator gambar hero">
              @foreach($heroImages as $index => $image)
                <button class="hero-indicator {{ $index === 0 ? 'is-active' : '' }}" type="button" aria-label="Gambar hero {{ $index + 1 }}"></button>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="fasilitas" class="facility-detail py-5">
      <div class="container">
        <div class="section-title">
          <span class="section-kicker">Fasilitas</span>
          <h2>Tempat nyaman untuk olahraga dan berkumpul</h2>
          <p>Semua fasilitas dirancang agar proses bermain, menunggu, dan booking terasa lebih nyaman.</p>
        </div>

        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <h2>Lapangan Badminton</h2>
            <p>Lapangan badminton GOR GAZA menggunakan lantai berkualitas dengan pencahayaan terang dan nyaman.</p>
            <ul class="facility-list">
              <li><i class="fa-solid fa-circle-check"></i> Lapangan standar pertandingan</li>
              <li><i class="fa-solid fa-circle-check"></i> Pencahayaan LED terang</li>
              <li><i class="fa-solid fa-circle-check"></i> Tersedia sewa raket dan kok</li>
            </ul>
          </div>
          <div class="col-lg-6">
            <div class="gallery-grid">
              @foreach($galleryImages('Badminton', [
                ['path_gambar' => 'images/Bulutangkis-2.jpeg', 'alt_text' => 'Lapangan badminton'],
                ['path_gambar' => 'images/Bulutangkis-3.jpeg', 'alt_text' => 'Badminton indoor'],
                ['path_gambar' => 'images/Bulutangkis-4.jpeg', 'alt_text' => 'Permainan badminton'],
                ['path_gambar' => 'images/Bulutangkis-5.jpeg', 'alt_text' => 'Olahraga indoor'],
              ]) as $image)
                <img src="{{ asset($image->path_gambar) }}" alt="{{ $image->alt_text ?? 'Galeri badminton' }}" />
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="facility-detail facility-dark py-5">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6 order-lg-2">
            <h2>Meja Billiard Premium</h2>
            <p>Nikmati pengalaman bermain billiard dengan meja profesional, pencahayaan eksklusif, dan suasana yang nyaman untuk santai bersama teman.</p>
            <ul class="facility-list">
              <li><i class="fa-solid fa-circle-check"></i> Meja standar profesional</li>
              <li><i class="fa-solid fa-circle-check"></i> Cue stick berkualitas</li>
              <li><i class="fa-solid fa-circle-check"></i> Ruangan nyaman</li>
              <li><i class="fa-solid fa-circle-check"></i> Area santai dan lounge</li>
            </ul>
          </div>
          <div class="col-lg-6 order-lg-1">
            <div class="gallery-grid">
              @foreach($galleryImages('Billiard', [
                ['path_gambar' => 'images/Billiard-1.jpeg', 'alt_text' => 'Billiard premium'],
                ['path_gambar' => 'images/Billiard-2.jpeg', 'alt_text' => 'Meja billiard'],
                ['path_gambar' => 'images/Billiard-3.jpeg', 'alt_text' => 'Ruang billiard'],
                ['path_gambar' => 'images/Billiard-4.jpeg', 'alt_text' => 'Billiard lounge'],
              ]) as $image)
                <img src="{{ asset($image->path_gambar) }}" alt="{{ $image->alt_text ?? 'Galeri billiard' }}" />
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="facility-detail py-5">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <h2>Fasilitas Pendukung</h2>
            <p>Selain fasilitas olahraga, kami juga menyediakan berbagai fasilitas lainnya untuk kenyamanan Anda.</p>
            <div class="menu-list">
              <div class="menu-item"><span>Mushola</span></div>
              <div class="menu-item"><span>Toko</span></div>
              <div class="menu-item"><span>Toilet</span></div>
              <div class="menu-item"><span>Lounge</span></div>
              <div class="menu-item"><span>Parkiran</span></div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="gallery-grid">
              @foreach($galleryImages('Pendukung', [
                ['path_gambar' => 'images/Mushola-1.jpeg', 'alt_text' => 'Mushola'],
                ['path_gambar' => 'images/Kursi.jpeg', 'alt_text' => 'Area duduk'],
                ['path_gambar' => 'images/Toko.jpeg', 'alt_text' => 'Toko'],
                ['path_gambar' => 'images/Toilet.jpeg', 'alt_text' => 'Toilet'],
                ['path_gambar' => 'images/Parkiran.jpeg', 'alt_text' => 'Parkiran'],
                ['path_gambar' => 'images/ParkiranAll.jpeg', 'alt_text' => 'Area parkir'],
              ]) as $image)
                <img src="{{ asset($image->path_gambar) }}" alt="{{ $image->alt_text ?? 'Galeri fasilitas pendukung' }}" />
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="harga" class="price-section py-5">
      <div class="container">
        <div class="section-title">
          <span class="section-kicker">Informasi Harga</span>
          <h2>Tarif sewa dan item tambahan</h2>
          <p>Harga berikut ditampilkan sebagai informasi untuk pengunjung. Item raket dan kok dapat dikonfirmasi langsung di lokasi.</p>
        </div>
        <div class="row g-4">
          <div class="col-md-6 col-xl-3">
            @php($badminton = $facilities['Badminton'] ?? null)

<div class="price-card h-100">
    <div class="price-icon">
        <i class="fa-solid fa-building"></i>
    </div>

    <h4>Sewa Lapang GOR</h4>

    <div class="price-value">

        @if($badminton)

            @if(
                $badminton->harga_promo &&
                $badminton->promo_mulai &&
                $badminton->promo_selesai
            )

                <div style="font-size:18px;color:#999;text-decoration:line-through">
                    Rp{{ number_format($badminton->harga_per_jam,0,',','.') }}
                </div>

                Rp{{ number_format($badminton->harga_promo,0,',','.') }}
                <span>/jam</span>

                <div class="mt-2 text-success fw-bold">
                    🔥 Promo
                </div>

                <small>
                    {{ \Carbon\Carbon::parse($badminton->promo_mulai)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($badminton->promo_selesai)->format('H:i') }}
                </small>

            @else

                Rp{{ number_format($badminton->harga_per_jam,0,',','.') }}
                <span>/jam</span>

            @endif

        @endif

    </div>

    <p>
        Untuk booking lapangan badminton sesuai jadwal yang tersedia.
    </p>

</div>
          </div>
          <div class="col-md-6 col-xl-3">
            @php($billiard = $facilities['Billiard'] ?? null)

<div class="price-card h-100">

    <div class="price-icon">
        <i class="fa-solid fa-circle-dot"></i>
    </div>

    <h4>Sewa Meja Billiard</h4>

    <div class="price-value">

        @if($billiard)

            @if(
                $billiard->harga_promo &&
                $billiard->promo_mulai &&
                $billiard->promo_selesai
            )

                <div style="font-size:18px;color:#999;text-decoration:line-through">
                    Rp{{ number_format($billiard->harga_per_jam,0,',','.') }}
                </div>

                Rp{{ number_format($billiard->harga_promo,0,',','.') }}
                <span>/jam</span>

                <div class="mt-2 text-success fw-bold">
                    🔥 Promo
                </div>

                <small>
                    {{ \Carbon\Carbon::parse($billiard->promo_mulai)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($billiard->promo_selesai)->format('H:i') }}
                </small>

            @else

                Rp{{ number_format($billiard->harga_per_jam,0,',','.') }}
                <span>/jam</span>

            @endif

        @endif

    </div>

    <p>
        Untuk booking meja billiard sesuai jadwal yang tersedia.
    </p>

</div>
          </div>
          <div class="col-md-6 col-xl-3">
            <div class="price-card h-100 muted">
              <div class="price-icon"><i class="fa-solid fa-toolbox"></i></div>
              <h4>Sewa Raket</h4>
              <div class="price-value">Rp10.000</div>
              <p>Tambahan opsional, dibayar dan dikonfirmasi langsung di lokasi.</p>
            </div>
          </div>
          <div class="col-md-6 col-xl-3">
            <div class="price-card h-100 muted">
              <div class="price-icon"><i class="fa-solid fa-feather"></i></div>
              <h4>Kok Badminton</h4>
              <div class="price-value">Rp10.000<span>/buah</span></div>
              <p>Pembelian kok dapat dilakukan langsung di lokasi GOR GAZA.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="menu-kafe" class="cafe-menu-section py-5">
      <div class="container">
        <div class="section-title">
          <span class="section-kicker">Menu Kafe</span>
          <h2>Pilihan makanan dan minuman</h2>
          <p>Menu kafe ditampilkan sebagai informasi. Untuk saat ini pemesanan menu belum tersedia melalui sistem booking online.</p>
        </div>
        <div class="row g-4">
          @forelse($cafeMenus as $kategori => $menus)
            <div class="col-lg-4">
              <div class="menu-card h-100">
                <h4><i class="fa-solid fa-utensils me-2"></i>{{ $kategori }}</h4>
                @foreach($menus as $menu)
                  @if($menu->gambar)
                    <button class="menu-row menu-row-with-image menu-row-clickable cafe-image-open" type="button" data-image-src="{{ asset($menu->gambar) }}" data-image-title="{{ $menu->nama_menu }}" title="Lihat gambar {{ $menu->nama_menu }}">
                      <img class="menu-row-image" src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama_menu }}">
                      <div class="menu-row-content">
                        <span class="menu-row-name">{{ $menu->nama_menu }}</span>
                        @if($menu->deskripsi)
                          <small class="menu-row-description">{{ $menu->deskripsi }}</small>
                        @endif
                      </div>
                      <strong>{{ $formatMenuPrice($menu->harga) }}</strong>
                    </button>
                  @else
                    <div class="menu-row menu-row-with-image">
                      <div class="menu-row-image menu-row-image-placeholder" aria-hidden="true">
                        <i class="fa-solid fa-utensils"></i>
                      </div>
                      <div class="menu-row-content">
                        <span class="menu-row-name">{{ $menu->nama_menu }}</span>
                        @if($menu->deskripsi)
                          <small class="menu-row-description">{{ $menu->deskripsi }}</small>
                        @endif
                      </div>
                      <strong>{{ $formatMenuPrice($menu->harga) }}</strong>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="menu-card text-center">
                <h4>Menu kafe belum tersedia</h4>
                <p class="menu-note mb-0">Admin dapat menambahkan menu melalui panel admin.</p>
              </div>
            </div>
          @endforelse
        </div>
        <div class="cafe-coming-soon mt-4">
          <div>
            <h4><i class="fa-solid fa-bell-concierge me-2"></i>Pemesanan Menu Online</h4>
            <p>Menu kafe sudah tersedia sebagai katalog. Pemesanan online akan diaktifkan pada pengembangan berikutnya setelah alur operasional kafe siap.</p>
          </div>
          <button type="button" class="btn btn-warning rounded-pill fw-bold" disabled>
            <i class="fa-solid fa-clock me-2"></i>Segera Hadir
          </button>
        </div>
      </div>
    </section>

    <section id="jadwal" class="py-5 schedule-section">
      <div class="container">
        <div class="section-title">
          <span class="section-kicker">Jadwal</span>
          <h2>Cek Ketersediaan Lapangan</h2>
          <p>Pilih tanggal dan fasilitas untuk melihat status booking secara langsung.</p>
        </div>

        <div class="row g-4 align-items-stretch">
          <div class="col-lg-5 d-flex">
            <div class="schedule-card w-100 h-100">
              <div class="schedule-card-header">
                <h4>Kalender</h4>
                <span>Pilih tanggal yang ingin dicek</span>
              </div>
              <div class="calendar">
                <div class="calendar-header">
                  <button id="prevMonth" class="btn btn-sm btn-outline-light landing-page-hidden" type="button">&#8249;</button>
                  <div id="monthYear"></div>
                  <button id="nextMonth" class="btn btn-sm btn-outline-light landing-page-hidden" type="button">&#8250;</button>
                </div>
                <div class="calendar-weekdays">
                  <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                </div>
                <div id="calendarDays" class="calendar-days"></div>
              </div>
              <div class="booking-note"><b>Ketentuan pemesanan:</b><br />Mohon lengkapi data sebelum konfirmasi.</div>
            </div>
          </div>

          <div class="col-lg-7 d-flex">
            <div class="schedule-card schedule-right w-100 h-100">
              <div class="schedule-card-header">
                <h4>Detail Jadwal</h4>
                <span id="selectedDateLabel">Tanggal dipilih: --</span>
                <div class="facility-switch mt-3">
                  <button id="showBadminton" class="btn btn-warning btn-sm active-facility" type="button">Badminton</button>
                  <button id="showBilliard" class="btn btn-outline-warning btn-sm" type="button">Billiard</button>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-dark table-striped schedule-table">
                  <thead>
                    <tr><th>Jam</th><th>Status</th></tr>
                  </thead>
                  <tbody id="scheduleBody"></tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="lokasi" class="section-dark py-5">
      <div class="container">
        <div class="section-title">
          <span class="section-kicker">Lokasi</span>
          <h2>Temukan GOR GAZA</h2>
          <p>Datang langsung ke lokasi kami untuk bermain atau melakukan konfirmasi.</p>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.6659845305962!2d107.72897677430898!3d-6.930467667837023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68c32beb089127%3A0x99c535f8f29188a6!2sGor%20Gaza!5e0!3m2!1sid!2sid!4v1780551031421!5m2!1sid!2sid" width="600" height="450" style="border:0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map-iframe"></iframe>

        <div id="kritik-saran" class="feedback-private-card mt-5">
          <div class="row g-4 align-items-center">
            <div class="col-lg-5">
              <span class="section-kicker">Kritik & Saran</span>
              <h3>Bantu kami meningkatkan layanan GOR GAZA</h3>
              <p>Pesan yang dikirim bersifat privat dan hanya dapat dibaca oleh admin GOR GAZA.</p>
            </div>
            <div class="col-lg-7">
              @if(session('success'))
                <div class="alert alert-success rounded-4 border-0">{{ session('success') }}</div>
              @endif

              @if(session('auth_user'))
                <form action="{{ route('feedback.store') }}" method="POST">
                  @csrf
                  <label class="form-label fw-bold text-light">Tulis kritik atau saran</label>
                  <textarea name="pesan" class="form-control feedback-textarea" rows="4" maxlength="1000" placeholder="Contoh: jadwal, pelayanan, fasilitas, atau saran untuk GOR GAZA..." required>{{ old('pesan') }}</textarea>
                  @error('pesan')
                    <div class="text-warning small mt-2">{{ $message }}</div>
                  @enderror
                  <button type="submit" class="btn btn-warning rounded-pill fw-bold px-4 mt-3">
                    <i class="fa-solid fa-paper-plane me-2"></i>Kirim ke Admin
                  </button>
                </form>
              @else
                <div class="feedback-login-box">
                  <i class="fa-solid fa-lock me-2"></i>Silakan masuk terlebih dahulu untuk mengirim kritik dan saran.
                  <div class="mt-3">
                    <a href="/login" class="btn btn-warning rounded-pill fw-bold px-4">Masuk Sekarang</a>
                  </div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer>
      <div class="container text-center">
        <p>© 2026 GOR GAZA. Seluruh hak cipta dilindungi.</p>
      </div>
    </footer>

    <a href="https://wa.me/6282215309779" class="whatsapp-float" target="_blank" rel="noopener" aria-label="Hubungi WhatsApp GOR GAZA">
      <i class="fab fa-whatsapp"></i>
    </a>

    <div class="cafe-image-lightbox" id="cafeImageLightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Pratinjau gambar menu kafe">
      <div class="cafe-image-lightbox-backdrop" data-cafe-image-close></div>
      <div class="cafe-image-lightbox-panel">
        <button type="button" class="cafe-image-lightbox-close" data-cafe-image-close aria-label="Tutup gambar">
          <i class="fa-solid fa-xmark"></i>
        </button>
        <img id="cafeLightboxImage" src="" alt="Gambar menu kafe">
        <div class="cafe-image-lightbox-title" id="cafeLightboxTitle"></div>
      </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const lightbox = document.getElementById('cafeImageLightbox');
        const lightboxImage = document.getElementById('cafeLightboxImage');
        const lightboxTitle = document.getElementById('cafeLightboxTitle');
        const openButtons = document.querySelectorAll('.cafe-image-open');
        const closeButtons = document.querySelectorAll('[data-cafe-image-close]');

        if (!lightbox || !lightboxImage || !openButtons.length) return;

        const closeLightbox = () => {
          lightbox.classList.remove('is-open');
          lightbox.setAttribute('aria-hidden', 'true');
          document.body.classList.remove('cafe-lightbox-open');
          lightboxImage.removeAttribute('src');
        };

        openButtons.forEach((button) => {
          button.addEventListener('click', () => {
            const imageSrc = button.dataset.imageSrc;
            const imageTitle = button.dataset.imageTitle || 'Gambar menu kafe';

            if (!imageSrc) return;

            lightboxImage.src = imageSrc;
            lightboxImage.alt = imageTitle;
            if (lightboxTitle) lightboxTitle.textContent = imageTitle;

            lightbox.classList.add('is-open');
            lightbox.setAttribute('aria-hidden', 'false');
            document.body.classList.add('cafe-lightbox-open');
          });
        });

        closeButtons.forEach((button) => button.addEventListener('click', closeLightbox));

        document.addEventListener('keydown', (event) => {
          if (event.key === 'Escape' && lightbox.classList.contains('is-open')) {
            closeLightbox();
          }
        });
      });
    </script>
  </body>
</html>
