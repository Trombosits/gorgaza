<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>GOR GAZA - Booking Lapangan & Billiard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  </head>
  <body class="frontend-page">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top app-navbar">
      <div class="container">
        <a class="navbar-brand brand-mark" href="/">
          <span class="brand-icon">GG</span>
          <span>GOR GAZA</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item"><a class="nav-link" href="#hero">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="#fasilitas">Fasilitas</a></li>
            <li class="nav-item"><a class="nav-link" href="#jadwal">Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="#lokasi">Lokasi</a></li>
          </ul>

          <div class="nav-auth d-flex gap-2">
            @if(session('auth_user.role') === 'admin')
              <a class="btn btn-outline-light rounded-pill px-3" href="/admin/dashboard">Admin</a>
            @elseif(session('auth_user'))
              <a class="btn btn-outline-light rounded-pill px-3" href="/booking">Booking</a>
            @else
              <a class="btn btn-book" href="/login">Login / Daftar</a>
            @endif
          </div>
        </div>
      </div>
    </nav>

    <section class="hero" id="hero">
      <div class="hero-overlay"></div>
      <div class="container position-relative">
        <div class="row align-items-center g-5">
          <div class="col-lg-7">
            <h1>Booking <span>Lapangan</span> & <span>Billiard</span> Jadi Lebih Mudah</h1>
            <p>
              GOR GAZA menyediakan lapangan badminton, meja billiard premium, dan area santai dalam satu tempat. Cek jadwal, pilih sesi, lalu booking tanpa antre.
            </p>
            <div class="d-flex flex-wrap gap-3 mt-4">
              <a href="/booking" class="btn btn-warning btn-lg hero-cta">
                <i class="fas fa-calendar-check me-2"></i>Booking Sekarang
              </a>
              <a href="#jadwal" class="btn btn-outline-light btn-lg hero-cta-outline">
                <i class="fa-solid fa-clock me-2"></i>Cek Jadwal
              </a>
            </div>
            <div class="hero-stats mt-5">
              <div>
                <strong>Realtime</strong>
                <span>Status jadwal</span>
              </div>
              <div>
                <strong>2+</strong>
                <span>Jenis fasilitas</span>
              </div>
              <div>
                <strong>08-22</strong>
                <span>Jam operasional</span>
              </div>
            </div>
          </div>
          <div class="col-lg-5 d-none d-lg-block">
                </div>
              </div>
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
            <p>
              Lapangan badminton GOR GAZA menggunakan lantai berkualitas dengan pencahayaan terang dan nyaman.
            </p>
            <ul class="facility-list">
              <li><i class="fa-solid fa-circle-check"></i> Lapangan standar pertandingan</li>
              <li><i class="fa-solid fa-circle-check"></i> Pencahayaan LED terang</li>
              <li><i class="fa-solid fa-circle-check"></i> Ruang tunggu pemain</li>
            </ul>
          </div>

          <div class="col-lg-6">
            <div class="gallery-grid">
              <img src="/images/bulutangkis-2.jpeg" alt="Lapangan badminton" />
              <img src="/images/bulutangkis-3.jpeg" alt="Badminton indoor" />
              <img src="/images/bulutangkis-4.jpeg" alt="Permainan badminton" />
              <img src="/images/bulutangkis-5.jpeg" alt="Olahraga indoor" />
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
            <p>
              Nikmati pengalaman bermain billiard dengan meja profesional, pencahayaan eksklusif, dan suasana yang nyaman untuk santai bersama teman.
            </p>
            <ul class="facility-list">
              <li><i class="fa-solid fa-circle-check"></i> Meja standar profesional</li>
              <li><i class="fa-solid fa-circle-check"></i> Cue stick berkualitas</li>
              <li><i class="fa-solid fa-circle-check"></i> Ruangan nyaman</li>
              <li><i class="fa-solid fa-circle-check"></i> Area santai dan lounge</li>
            </ul>
          </div>

          <div class="col-lg-6 order-lg-1">
            <div class="gallery-grid">
              <img src="/images/billiard-1.jpeg" alt="Billiard premium" />
              <img src="/images/billiard-2.jpeg" alt="Meja billiard" />
              <img src="/images/billiard-3.jpeg" alt="Billiard room" />
              <img src="/images/billiard-4.jpeg" alt="Billiard lounge" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="facility-detail py-5">
      <div class="container">
        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <h2>Fasilitas</h2>
            <p>
              Selain fasilitas olahraga, kami juga menyediakan berbagai fasilitas lainnya untuk kenyamanan Anda.
            </p>
            <div class="menu-list">
              <div class="menu-item"><span>Mushola</span></div>
              <div class="menu-item"><span>Cappuccino</span><span>Rp22.000</span></div>
              <div class="menu-item"><span>French Fries</span><span>Rp20.000</span></div>
              <div class="menu-item"><span>Nasi Goreng Spesial</span><span>Rp28.000</span></div>
              <div class="menu-item"><span>Chicken Wings</span><span>Rp30.000</span></div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="gallery-grid">
              <img src="/images/Mushola-1.jpeg" alt="Cafe" />
              <img src="/images/Kursi.jpeg" alt="Cafe interior" />
              <img src="/images/Toko.jpeg" alt="Coffee" />
              <img src="/images/Toilet.jpeg" alt="Lounge" />
            </div>
          </div>
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
              <div class="booking-note"><b>Ketentuan booking:</b><br />Mohon lengkapi data sebelum konfirmasi.</div>
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
        <p>© 2026 GOR GAZA. All Rights Reserved.</p>
      </div>
    </footer>

    <a href="https://wa.me/6281234567890" class="whatsapp-float" target="_blank" rel="noopener" aria-label="Hubungi WhatsApp GOR GAZA">
      <i class="fab fa-whatsapp"></i>
    </a>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
