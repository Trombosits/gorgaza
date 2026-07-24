<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Pemesanan - GOR GAZA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand brand-mark" href="/">
          <img src="{{ asset('images/logo-gorgaza.png') }}" alt="GOR GAZA" class="navbar-logo-img">
          <span>GOR GAZA</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
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
              <form action="/logout" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-danger rounded-pill px-3">Keluar</button></form>
            @elseif(session('auth_user'))
              <a class="btn btn-outline-light rounded-pill px-3" href="/booking">Pemesanan</a>
              <a class="btn btn-warning rounded-pill px-3 fw-bold" href="/booking-history">Riwayat</a>
              <form action="/logout" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-danger rounded-pill px-3">Keluar</button></form>
            @else
              <a class="btn btn-book" href="/login">Masuk / Daftar</a>
            @endif
          </div>
        </div>
      </div>
    </nav>

    <section class="booking-confirm-section booking-polish-page">
      <div class="container">
        <div class="confirm-header text-center">
          <span class="section-eyebrow"><i class="fa-solid fa-clipboard-check me-2"></i>Langkah Terakhir</span>
          <h1 class="confirm-title">Konfirmasi Pemesanan</h1>
          <p class="confirm-subtitle">
          Periksa kembali detail pemesanan Anda. Untuk mengurangi pembatalan sepihak, pelanggan hanya perlu membayar DP sebesar <strong>Rp5.000</strong> melalui QRIS. Sisa pembayaran dilunasi saat datang ke GOR GAZA.
          </p>

        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="confirm-panel">
              <div class="confirm-section-card mb-4">
                <div class="confirm-section-heading">
                  <div class="confirm-heading-icon"><i class="fa-solid fa-calendar-days"></i></div>
                  <div>
                    <h4>Detail Pemesanan</h4>
                    <p>Pastikan kategori, tanggal, dan jam yang dipilih sudah benar.</p>
                  </div>
                </div>
                <ul id="bookingSummary" class="confirm-summary-list list-group"></ul>
              </div>

              <div class="confirm-section-card mb-4">
                <div class="confirm-section-heading">
                  <div class="confirm-heading-icon"><i class="fa-solid fa-user-check"></i></div>
                  <div>
                    <h4>Data Pengguna</h4>
                    <p>Data pelanggan diambil dari akun yang sedang login.</p>
                  </div>
                </div>
                <ul id="userSummary" class="confirm-summary-list list-group"></ul>
              </div>

              <div class="confirm-section-card mb-4">
                <div class="confirm-section-heading">
                  <div class="confirm-heading-icon"><i class="fa-solid fa-credit-card"></i></div>
                  <div>
                    <h4>Metode Pembayaran</h4>
                    <p>GOR GAZA saat ini menggunakan pembayaran QRIS saja.</p>
                  </div>
                </div>

                <div class="payment-choice-grid polished-payment-grid payment-choice-grid-qris-only">
                  <label class="payment-choice polished-payment-choice active" for="paymentQris">
                    <input class="form-check-input payment-method-option" type="radio" name="metode_pembayaran" id="paymentQris" value="QRIS" checked>
                    <div class="payment-choice-icon"><i class="fa-solid fa-qrcode"></i></div>
                    <div>
                      <div class="payment-choice-title">
                        DP QRIS Rp5.000
                      </div>

                      <p>
                      Bayar uang muka (DP) sebesar Rp5.000 melalui QRIS. Sisa pembayaran dibayarkan langsung di lokasi saat jadwal booking.
                      </p>
                    </div>
                  </label>
                </div>
              </div>
              <div class="confirm-section-card mb-4">

            <div class="confirm-section-heading">
                <div class="confirm-heading-icon">
                    <i class="fa-solid fa-wallet"></i>
                </div>

                <div>
                    <h4>Ringkasan Pembayaran</h4>
                    <p>Nominal DP dan sisa pembayaran.</p>
                </div>
            </div>

            <ul class="list-group">

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total Booking</span>
                    <strong id="summaryTotal">Rp0</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>DP Dibayar Sekarang</span>
                    <strong class="text-success">
                        Rp5.000
                    </strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Sisa Pembayaran</span>
                    <strong id="summaryRemaining">
                        Rp0
                    </strong>
                </li>

            </ul>

        </div>

              <div class="confirm-info-box mb-4">

                    <i class="fa-solid fa-circle-info"></i>

                    <span>

                    Setelah DP berhasil dibayar, admin akan mengubah status menjadi
                    <strong>DP Lunas</strong>.

                    Sisa pembayaran dilunasi langsung di lokasi sebelum bermain.

                    </span>

                    </div>

              <div class="confirm-action-row">
                <a href="/booking-schedule" class="btn-back-booking"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
                <button id="confirmBooking" class="btn-confirm-booking" type="button">
                  <span class="btn-text"><i class="fa-solid fa-circle-check me-2"></i>Konfirmasi Pemesanan</span>
                  <span class="btn-loading d-none"><i class="fa-solid fa-spinner fa-spin me-2"></i>Memproses...</span>
                </button>
              </div>

              <div id="confirmMessage" class="mt-3">
                @if(session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
                @endif
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

    <a href="https://wa.me/6282215309779" class="whatsapp-float" target="_blank" rel="noopener">
      <i class="fab fa-whatsapp"></i>
    </a>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
