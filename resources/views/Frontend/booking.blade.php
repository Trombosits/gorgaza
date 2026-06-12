<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking - GOR GAZA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      rel="stylesheet"
    />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand brand-mark" href="/">
          <img src="{{ asset('images/logo-gorgaza.png') }}" alt="GOR GAZA" class="navbar-logo-img">
          <span>GOR GAZA</span>
        </a>

        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#menu"
        >
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
      <button type="submit" class="btn btn-danger rounded-pill px-3">Logout</button>
    </form>

  @elseif(session('auth_user'))
    <a class="btn btn-outline-light rounded-pill px-3" href="/booking">Booking</a>
    
    <form action="/logout" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-danger rounded-pill px-3">Logout</button>
    </form>

  @else
    <a class="btn btn-book" href="/login">Login / Daftar</a>
  @endif
</div>
        </div>
      </div>
    </nav>

    <section class="booking-category-section booking-polish-page">
      <div class="container">
        <div class="booking-category-shell">
          <div class="booking-category-header text-center">
            <span class="section-eyebrow"><i class="fa-solid fa-calendar-check me-2"></i>GOR GAZA Booking</span>
            <h1 class="booking-category-title">Pilih Kategori Booking</h1>
            <p class="booking-category-subtitle">
              Pilih fasilitas yang ingin kamu gunakan. Setelah itu, lanjutkan ke pemilihan tanggal dan jam yang tersedia.
            </p>
          </div>

          <div class="booking-category-grid">
            <button id="chooseBadminton" class="booking-category-card booking-category-card--yellow" type="button">
              <div class="booking-card-topline">
                <div class="booking-category-icon"><i class="fa-solid fa-table-tennis-paddle-ball"></i></div>
                <span class="booking-category-badge">Populer</span>
              </div>
              <h3>Lapangan Badminton</h3>
              <p>Booking lapangan badminton indoor dengan jadwal yang tersedia secara real-time.</p>
              <div class="booking-category-action">
                <span>Pilih Badminton</span>
                <i class="fa-solid fa-arrow-right"></i>
              </div>
            </button>

            <button id="chooseBilliard" class="booking-category-card booking-category-card--dark" type="button">
              <div class="booking-card-topline">
                <div class="booking-category-icon"><i class="fa-solid fa-table-cells-large"></i></div>
                <span class="booking-category-badge">Indoor</span>
              </div>
              <h3>Meja Billiard</h3>
              <p>Pilih sesi billiard, tentukan jam bermain, lalu lanjutkan ke konfirmasi pembayaran.</p>
              <div class="booking-category-action">
                <span>Pilih Billiard</span>
                <i class="fa-solid fa-arrow-right"></i>
              </div>
            </button>
          </div>
        </div>
      </div>
    </section>
    <footer>
      <div class="container text-center">
        <p>© 2026 GOR GAZA. All Rights Reserved.</p>
      </div>
    </footer>

    <a
      href="https://wa.me/6282215309779"
      class="whatsapp-float"
      target="_blank"
    >
      <i class="fab fa-whatsapp"></i>
    </a>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
