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
        <a class="navbar-brand" href="/landing_page">GOR GAZA</a>

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
              <a class="nav-link" href="/#hero">Booking</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/#fasilitas"
                >Fasilitas</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/#jadwal">Jadwal</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/#lokasi">Lokasi</a>
            </li>
          </ul>

          <div class="nav-auth">
            <a class="btn btn-book" href="/login">Login / Daftar</a>
          </div>
        </div>
      </div>
    </nav>

    <section
      style="
        min-height: calc(100vh - 70px);
        display: flex;
        justify-content: center;
        align-items: center;
      "
    >
      <div class="container text-center">
        <div class="section-title">
          <h2>Pilih Kategori Booking</h2>
          <p>Pilih lapangan badminton atau meja billiard untuk melanjutkan.</p>
        </div>

        <div class="d-flex gap-4 justify-content-center flex-wrap mt-5">
          <button
            id="chooseBadminton"
            class="btn btn-warning btn-lg"
            style="padding: 30px 50px; font-size: 1.2rem; border-radius: 15px"
          >
            <i class="fas fa-badminton me-2"></i>
            Lapangan Badminton
          </button>
          <button
            id="chooseBilliard"
            class="btn btn-dark btn-lg text-white"
            style="padding: 30px 50px; font-size: 1.2rem; border-radius: 15px"
          >
            <i class="fas fa-table me-2"></i>
            Meja Billiard
          </button>
        </div>
      </div>
    </section>

    <footer>
      <div class="container text-center">
        <p>© 2026 GOR GAZA. All Rights Reserved.</p>
      </div>
    </footer>

    <a
      href="https://wa.me/6281234567890"
      class="whatsapp-float"
      target="_blank"
    >
      <i class="fab fa-whatsapp"></i>
    </a>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
