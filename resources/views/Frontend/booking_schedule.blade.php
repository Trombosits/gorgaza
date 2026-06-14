<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Jadwal - GOR GAZA</title>
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

    <section class="py-5" style="margin-top: 50px">
      <div class="container">
        <div class="section-title mb-5">
          <h2>Pilih Jadwal</h2>
          <p>
            Pilih tanggal dan jam yang tersedia untuk jenis pemesanan Anda. Anda
            dapat memilih lebih dari satu jam.
          </p>
        </div>

        <div class="row g-4 align-items-stretch justify-content-center">
          <div class="col-lg-5 d-flex">
            <div class="schedule-card w-100 h-100">
              <div class="schedule-card-header">
                <h4>Kalender</h4>
              </div>
              <div class="calendar">
                <div class="calendar-header">
                  <button id="prevMonth" class="btn btn-sm btn-outline-light">
                    &#8249;
                  </button>
                  <div id="monthYear"></div>
                  <button id="nextMonth" class="btn btn-sm btn-outline-light">
                    &#8250;
                  </button>
                </div>
                <div class="calendar-weekdays">
                  <div>Min</div>
                  <div>Sen</div>
                  <div>Sel</div>
                  <div>Rab</div>
                  <div>Kam</div>
                  <div>Jum</div>
                  <div>Sab</div>
                </div>
                <div id="calendarDays" class="calendar-days"></div>
              </div>
              <div class="booking-note">
                Ketentuan pemesanan: mohon lengkapi data sebelum konfirmasi. Anda
                dapat memilih lebih dari satu jam pada tanggal yang sama.
              </div>
            </div>
          </div>

          <div class="col-lg-7 d-flex">
            <div class="schedule-card schedule-right w-100 h-100">
              <div class="schedule-card-header">
                <h4>Detail Jadwal</h4>
                <span id="selectedDateLabel">Tanggal dipilih: --</span>
              </div>
              <div class="table-responsive">
                <table class="table table-dark table-striped schedule-table">
                  <thead>
                    <tr>
                      <th>Jam</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="scheduleBody"></tbody>
                </table>
              </div>

              <div class="d-flex justify-content-between mt-3">
                <a href="/booking" class="btn btn-outline-light">Kembali</a>
                <button id="continueToConfirm" class="btn btn-book">
                  Lanjut
                </button>
              </div>
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
