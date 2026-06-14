<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Masuk - GOR GAZA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
  </head>

  <body class="auth-page">
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
            @elseif(session('auth_user'))
              <a class="btn btn-outline-light rounded-pill px-3" href="/booking">Pemesanan</a>
            @else
              <a class="btn btn-book" href="/login">Masuk / Daftar</a>
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
              <h1>Masuk dan lanjutkan pemesanan kamu.</h1>
              <p>Cek jadwal, pilih sesi, dan pantau konfirmasi booking dengan akun GOR GAZA.</p>
            </div>
          </div>

          <div class="col-lg-5 col-md-8">
            <div class="auth-card modern-auth-card">
              <div class="text-center mb-4">
                <div class="auth-icon mx-auto mb-3"><i class="fa-solid fa-right-to-bracket"></i></div>
                <h2>Masuk ke GOR GAZA</h2>
                <p>Gunakan akun Anda untuk melakukan booking lapangan dan billiard.</p>
              </div>

              <div id="authAlert" class="auth-alert d-none"></div>

              @if(session('success'))
                <div class="alert alert-success rounded-4 border-0">{{ session('success') }}</div>
              @endif

              <form id="loginForm" novalidate>
                <div class="mb-3">
                  <label class="form-label" for="loginEmail">Email</label>
                  <div class="input-icon-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input id="loginEmail" type="email" class="form-control" placeholder="nama@email.com" autocomplete="email" required />
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label" for="loginPassword">Kata Sandi</label>
                  <div class="input-icon-wrap">
                    <i class="fa-solid fa-lock"></i>
                    <input id="loginPassword" type="password" class="form-control" placeholder="Masukkan kata sandi" autocomplete="current-password" required />
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 auth-footer">
                  <span>Belum punya akun?</span>
                  <a href="/register" class="text-decoration-none">Daftar sekarang</a>
                </div>

                <button type="submit" class="btn btn-book w-100 auth-submit">
                  <span class="btn-text"><i class="fas fa-sign-in-alt me-2"></i>Masuk</span>
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
