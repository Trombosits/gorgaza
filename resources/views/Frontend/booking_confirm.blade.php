<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Konfirmasi Booking - GOR GAZA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/">GOR GAZA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
          <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item"><a class="nav-link" href="/#hero">Booking</a></li>
            <li class="nav-item"><a class="nav-link" href="/#fasilitas">Fasilitas</a></li>
            <li class="nav-item"><a class="nav-link" href="/#harga">Harga</a></li>
            <li class="nav-item"><a class="nav-link" href="/#jadwal">Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="/#lokasi">Lokasi</a></li>
          </ul>
          <div class="nav-auth d-flex gap-2">
            @if(session('auth_user.role') === 'admin')
              <a class="btn btn-outline-light rounded-pill px-3" href="/admin/dashboard">Admin</a>
              <form action="/logout" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-danger rounded-pill px-3">Logout</button></form>
            @elseif(session('auth_user'))
              <a class="btn btn-outline-light rounded-pill px-3" href="/booking">Booking</a>
              <form action="/logout" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-danger rounded-pill px-3">Logout</button></form>
            @else
              <a class="btn btn-book" href="/login">Login / Daftar</a>
            @endif
          </div>
        </div>
      </div>
    </nav>

    <section class="py-5" style="margin-top: 50px">
      <div class="container">
        <div class="section-title mb-5">
          <h2>Konfirmasi Booking</h2>
          <p>Periksa detail booking dan pilih metode pembayaran sebelum konfirmasi akhir.</p>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-9">
            <div class="feature-box">
              <h4>Detail Booking</h4>
              <ul id="bookingSummary" class="list-group mb-4"></ul>

              <h4>Data Pengguna</h4>
              <ul id="userSummary" class="list-group mb-4"></ul>

              <h4>Metode Pembayaran</h4>
              <div class="payment-choice-grid mb-4">
                <label class="payment-choice active" for="paymentQris">
                  <input class="form-check-input payment-method-option" type="radio" name="metode_pembayaran" id="paymentQris" value="QRIS / GoPay" checked>
                  <div>
                    <div class="payment-choice-title"><i class="fa-solid fa-qrcode me-2"></i>Bayar Online QRIS/GoPay</div>
                    <p>Bayar di awal dengan scan QR. Status pembayaran tetap Pending sampai admin mengonfirmasi.</p>
                  </div>
                </label>
                <label class="payment-choice" for="paymentCash">
                  <input class="form-check-input payment-method-option" type="radio" name="metode_pembayaran" id="paymentCash" value="Cash / Bayar di Tempat">
                  <div>
                    <div class="payment-choice-title"><i class="fa-solid fa-money-bill-wave me-2"></i>Cash / Bayar di Tempat</div>
                    <p>Bayar setelah bermain langsung ke admin/kasir GOR GAZA.</p>
                  </div>
                </label>
              </div>

              <div class="alert alert-warning rounded-4">
                <i class="fa-solid fa-circle-info me-2"></i>
                Untuk pembayaran online maupun cash, admin tetap akan mengubah status pembayaran menjadi <strong>Paid</strong> setelah pembayaran diterima.
              </div>

              <div class="d-flex justify-content-between flex-wrap gap-2">
                <a href="/booking-schedule" class="btn btn-outline-light">Kembali</a>
                <button id="confirmBooking" class="btn btn-warning">
                  <span class="btn-text"><i class="fa-solid fa-check me-2"></i>Konfirmasi Booking</span>
                  <span class="btn-loading d-none">Memproses...</span>
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
        <p>© 2026 GOR GAZA. All Rights Reserved.</p>
      </div>
    </footer>

    <a href="https://wa.me/6282215309779" class="whatsapp-float" target="_blank" rel="noopener">
      <i class="fab fa-whatsapp"></i>
    </a>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
