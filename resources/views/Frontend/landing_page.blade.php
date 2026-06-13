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
        <div class="hero-slide is-active" style="background-image: url('{{ asset('images/Bulutangkis-9.jpeg') }}')"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/Billiard.jpeg') }}')"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/Bulutangkis-6.jpeg') }}')"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/Bulutangkis-2.jpeg') }}')"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/Billiard-2.jpeg') }}')"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/Kursi.jpeg') }}')"></div>
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
                <strong>08.00-22.00 WIB</strong>
                <span>Jam operasional</span>
              </div>
              <div>
                <strong>QRIS & Tunai</strong>
                <span>Pembayaran fleksibel</span>
              </div>
            </div>
            <div class="hero-slider-indicators" aria-label="Indikator gambar hero">
              <button class="hero-indicator is-active" type="button" aria-label="Gambar hero 1"></button>
              <button class="hero-indicator" type="button" aria-label="Gambar hero 2"></button>
              <button class="hero-indicator" type="button" aria-label="Gambar hero 3"></button>
              <button class="hero-indicator" type="button" aria-label="Gambar hero 4"></button>
              <button class="hero-indicator" type="button" aria-label="Gambar hero 5"></button>
              <button class="hero-indicator" type="button" aria-label="Gambar hero 6"></button>
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
              <img src="/images/Bulutangkis-2.jpeg" alt="Lapangan badminton" />
              <img src="/images/Bulutangkis-3.jpeg" alt="Badminton indoor" />
              <img src="/images/Bulutangkis-4.jpeg" alt="Permainan badminton" />
              <img src="/images/Bulutangkis-5.jpeg" alt="Olahraga indoor" />
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
              <img src="/images/Billiard-1.jpeg" alt="Billiard premium" />
              <img src="/images/Billiard-2.jpeg" alt="Meja billiard" />
              <img src="/images/Billiard-3.jpeg" alt="Billiard room" />
              <img src="/images/Billiard-4.jpeg" alt="Billiard lounge" />
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
              <img src="/images/Mushola-1.jpeg" alt="Mushola" />
              <img src="/images/Kursi.jpeg" alt="Area duduk" />
              <img src="/images/Toko.jpeg" alt="Toko" />
              <img src="/images/Toilet.jpeg" alt="Toilet" />
              <img src="/images/Parkiran.jpeg" alt="Parkiran" />
              <img src="/images/ParkiranAll.jpeg" alt="Area parkir" />
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
            <div class="price-card h-100">
              <div class="price-icon"><i class="fa-solid fa-table-tennis-paddle-ball"></i></div>
              <h4>Sewa Lapang GOR</h4>
              <div class="price-value">Rp25.000<span>/jam</span></div>
              <p>Untuk booking lapangan badminton sesuai jadwal yang tersedia.</p>
            </div>
          </div>
          <div class="col-md-6 col-xl-3">
            <div class="price-card h-100">
              <div class="price-icon"><i class="fa-solid fa-circle-dot"></i></div>
              <h4>Sewa Meja Billiard</h4>
              <div class="price-value">Rp30.000<span>/jam</span></div>
              <p>Untuk booking meja billiard sesuai jadwal yang tersedia.</p>
            </div>
          </div>
          <div class="col-md-6 col-xl-3">
            <div class="price-card h-100 muted">
              <div class="price-icon"><i class="fa-solid fa-baseball-bat-ball"></i></div>
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
          <div class="col-lg-4">
            <div class="menu-card h-100">
              <h4><i class="fa-solid fa-bowl-food me-2"></i>Main Course</h4>
              <div class="menu-note">Dadar / ceplok / orek telor</div>
              <div class="menu-row"><span>Original</span><strong>Rp8.000</strong></div>
              <div class="menu-row"><span>Cumi</span><strong>Rp13.000</strong></div>
              <div class="menu-row"><span>Tongkol</span><strong>Rp13.000</strong></div>
              <div class="menu-row"><span>Teri</span><strong>Rp13.000</strong></div>
              <div class="menu-row"><span>Paru</span><strong>Rp13.000</strong></div>
              <div class="menu-row"><span>Daging</span><strong>Rp13.000</strong></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="menu-card h-100">
              <h4><i class="fa-solid fa-utensils me-2"></i>Mie & Extra</h4>
              <div class="menu-row"><span>Mie goreng polos</span><strong>TBD</strong></div>
              <div class="menu-row"><span>Mie goreng telor</span><strong>TBD</strong></div>
              <div class="menu-row"><span>Mie kuah polos</span><strong>TBD</strong></div>
              <div class="menu-row"><span>Mie kuah telor</span><strong>TBD</strong></div>
              <div class="menu-row"><span>Nasi</span><strong>Rp5.000</strong></div>
              <div class="menu-row"><span>Nasi setengah</span><strong>Rp3.000</strong></div>
              <div class="menu-row"><span>Telor dadar/ceplok/orek</span><strong>Rp5.000</strong></div>
              <div class="menu-row"><span>Oseng sambal</span><strong>Rp5.000</strong></div>
              <div class="menu-row"><span>Tahu / Tempe</span><strong>Rp2.000</strong></div>
              <div class="menu-row"><span>Sambal bawang / Kerupuk</span><strong>Rp2.000</strong></div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="menu-card h-100">
              <h4><i class="fa-solid fa-mug-saucer me-2"></i>Minuman & Snack</h4>
              <div class="menu-row"><span>Air mineral</span><strong>Rp3.000</strong></div>
              <div class="menu-row"><span>Isoplus / Floridina / Teh Pucuk</span><strong>Rp4.000</strong></div>
              <div class="menu-row"><span>Teh manis</span><strong>Rp4.000</strong></div>
              <div class="menu-row"><span>Lemon tea / Lemongrass tea</span><strong>Rp6.000</strong></div>
              <div class="menu-row"><span>Teh tarik / Jahe</span><strong>Rp6.000</strong></div>
              <div class="menu-row"><span>Jus jeruk/strawberry/mangga</span><strong>Rp8.000</strong></div>
              <div class="menu-row"><span>Jus alpukat</span><strong>Rp10.000</strong></div>
              <div class="menu-row"><span>Kopi hot/cold</span><strong>TBD</strong></div>
              <div class="menu-row"><span>Sosis kentang</span><strong>TBD</strong></div>
            </div>
          </div>
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

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
