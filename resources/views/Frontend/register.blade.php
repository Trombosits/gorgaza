<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Daftar - GOR GAZA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  </head>

  <body class="auth-page">
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
            <li class="nav-item"><a class="nav-link" href="/#hero">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="/#fasilitas">Fasilitas</a></li>
            <li class="nav-item"><a class="nav-link" href="/#jadwal">Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="/#lokasi">Lokasi</a></li>
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

    <main class="auth-shell">
      <div class="auth-bg-shape auth-bg-shape-1"></div>
      <div class="auth-bg-shape auth-bg-shape-2"></div>
      <div class="container position-relative">
        <div class="row align-items-center justify-content-center g-5">
          <div class="col-lg-5 d-none d-lg-block">
            <div class="auth-side-card glass-card">
              <div class="hero-badge mb-3"><i class="fa-solid fa-user-plus"></i> Mulai booking online</div>
              <h1>Buat akun untuk akses booking lebih cepat.</h1>
              <p>Data kamu dipakai untuk konfirmasi reservasi dan mempermudah proses pemesanan berikutnya.</p>
            </div>
          </div>

          <div class="col-lg-5 col-md-8">
            <div class="auth-card modern-auth-card">
              <div class="text-center mb-4">
                <div class="auth-icon mx-auto mb-3"><i class="fa-solid fa-user-plus"></i></div>
                <h2>Buat Akun Baru</h2>
                <p>Daftar untuk mulai booking lapangan dan bermain billiard di GOR GAZA.</p>
              </div>

              <div id="authAlert" class="auth-alert d-none"></div>

              <form id="registerForm" novalidate>
                <div class="mb-3">
                  <label class="form-label" for="regName">Nama Lengkap</label>
                  <div class="input-icon-wrap">
                    <i class="fa-solid fa-user"></i>
                    <input id="regName" type="text" class="form-control" placeholder="Masukkan nama lengkap" autocomplete="name" required />
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="regEmail">Email</label>
                  <div class="input-icon-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input id="regEmail" type="email" class="form-control" placeholder="nama@email.com" autocomplete="email" required />
                  </div>
                  <small class="text-muted">Gunakan Gmail, Yahoo, Outlook, UPI, Hotmail, atau Proton.</small>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="regPhone">Nomor Telepon</label>
                  <div class="input-icon-wrap">
                    <i class="fa-solid fa-phone"></i>
                    <input id="regPhone" type="tel" class="form-control" placeholder="0812xxxxxxx" autocomplete="tel" required />
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="regPassword">Password</label>
                  <div class="input-icon-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input id="regPassword" type="password" class="form-control" placeholder="Minimal 6 karakter" autocomplete="new-password" required />
                    <button class="password-toggle" type="button" data-target="regPassword" aria-label="Tampilkan password"><i class="fa-regular fa-eye"></i></button>
                  </div>
                </div>

                <div class="mb-4">
                  <label class="form-label" for="regPasswordConfirm">Konfirmasi Password</label>
                  <div class="input-icon-wrap">
                    <i class="fa-solid fa-shield-halved"></i>
                    <input id="regPasswordConfirm" type="password" class="form-control" placeholder="Ulangi password" autocomplete="new-password" required />
                    <button class="password-toggle" type="button" data-target="regPasswordConfirm" aria-label="Tampilkan password"><i class="fa-regular fa-eye"></i></button>
                  </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 auth-footer">
                  <span>Sudah punya akun?</span>
                  <a href="/login" class="text-decoration-none">Masuk sekarang</a>
                </div>

                <button type="submit" class="btn btn-book w-100 auth-submit">
                  <span class="btn-text"><i class="fas fa-user-plus me-2"></i>Daftar</span>
                  <span class="btn-loading d-none"><span class="spinner-border spinner-border-sm me-2"></span>Memproses...</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
