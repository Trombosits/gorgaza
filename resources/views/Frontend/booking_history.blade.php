<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Pemesanan - GOR GAZA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
</head>
<body class="booking-history-page">
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
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#hero">Beranda</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#fasilitas">Fasilitas</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#harga">Harga</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#jadwal">Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#kritik-saran">Kritik & Saran</a></li>
          </ul>
        </div>

        <div class="nav-auth d-flex gap-2">
          <a class="btn btn-outline-light rounded-pill px-3" href="/booking">Pemesanan</a>
          <a class="btn btn-warning rounded-pill px-3 fw-bold" href="/booking-history">Riwayat</a>
          <form action="/logout" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger rounded-pill px-3">Keluar</button>
          </form>
        </div>
      </div>
    </nav>

    <main class="booking-history-wrap">
      <div class="container">
        <div class="booking-history-header text-center">
          <span class="section-kicker">Cek Status</span>
          <h1>Riwayat Pemesanan Saya</h1>
          <p>
          Gunakan halaman ini untuk memantau status pembayaran DP, sisa pembayaran, serta status pemesanan Anda.
          </p>
        </div>

        @if($transactions->isEmpty())
          <div class="empty-history-card text-center">
            <div class="empty-history-icon"><i class="fa-regular fa-calendar-xmark"></i></div>
            <h3>Belum ada pemesanan</h3>
            <p>Kamu belum memiliki transaksi pemesanan. Pilih fasilitas dan jadwal terlebih dahulu.</p>
            <a href="/booking" class="btn btn-warning rounded-pill px-4 fw-bold">Pesan Sekarang</a>
          </div>
        @else
          <div class="booking-history-list">
            @foreach($transactions as $transaction)
              @php
                $paymentStatus = $transaction->status_pembayaran ?? 'Pending';
                $paymentClass = strtolower($paymentStatus) === 'paid' ? 'paid' : (strtolower($paymentStatus) === 'cancelled' ? 'cancelled' : 'pending');
                $paymentLabels = [
                'Pending'=>'Menunggu DP',
                'Partial'=>'DP Diterima',
                'Paid'=>'Lunas',
                'Cancelled'=>'Dibatalkan'
                ];
                $reservationLabels = [
                    'Booking' => 'Menunggu',
                    'Confirmed' => 'Disetujui',
                    'Completed' => 'Selesai',
                    'Cancelled' => 'Dibatalkan',
                    'Out of Time' => 'Waktu Habis',
                ];
                $methodLabels = [
                    'Cash / Bayar di Tempat' => 'Tunai / Bayar di Tempat',
                    'Pay On Place' => 'Tunai / Bayar di Tempat',
                ];
                $method = preg_replace(['/QRIS\s*\/\s*Go\s*Pay/i', '/QRIS\/Go\s*Pay/i', '/Go\s*Pay/i'], 'QRIS', $transaction->metode_pembayaran ?? 'Cash / Bayar di Tempat');
                $method = $methodLabels[$method] ?? $method;
              @endphp

              <article class="history-card">
                <div class="history-card-main">
                  <div class="history-id-block">
                    <span class="history-label">ID Transaksi</span>
                    <h3>#{{ $transaction->id }}</h3>
                    <p>{{ optional($transaction->waktu_transaksi)->format('d M Y, H:i') ?? '-' }} WIB</p>
                  </div>

                  <div class="history-detail-block">
                    @forelse($transaction->reservations as $reservation)
                      <div class="history-reservation-row">
                        <div>
                          <span class="history-label">Fasilitas</span>
                          <strong>{{ $reservation->facility->nama_fasilitas ?? 'Fasilitas' }}</strong>
                        </div>
                        <div>
                          <span class="history-label">Tanggal & Jam</span>
                          <strong>
                            {{ \Carbon\Carbon::parse($reservation->waktu_mulai)->translatedFormat('d M Y') }} ·
                            {{ \Carbon\Carbon::parse($reservation->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->waktu_selesai)->format('H:i') }} WIB
                          </strong>
                        </div>
                        <div>
                          <span class="history-label">Status Pemesanan</span>
                          <span class="history-status booking">{{ $reservationLabels[$reservation->status_main] ?? $reservation->status_main }}</span>
                        </div>
                      </div>
                    @empty
                      <div class="history-reservation-row">
                        <strong>Detail reservasi tidak tersedia.</strong>
                      </div>
                    @endforelse
                  </div>
                </div>

                <div class="history-payment-block">

                <div>
                    <span class="history-label">Status Pembayaran</span>

                    <span class="history-status {{ $paymentClass }}">
                        {{ $paymentLabels[$paymentStatus] ?? $paymentStatus }}
                    </span>
                </div>

                <div>
                    <span class="history-label">Metode</span>

                    <strong>{{ $method }}</strong>
                </div>

                <div>
                    <span class="history-label">Total Booking</span>

                    <h5>
                        Rp {{ number_format($transaction->total_tagihan,0,',','.') }}
                    </h5>
                </div>

                <div>
                    <span class="history-label">DP Dibayar</span>

                    <strong class="text-success">
                        Rp {{ number_format($transaction->nominal_dp,0,',','.') }}
                    </strong>
                </div>

                <div>
                    <span class="history-label">Sisa Pembayaran</span>

                    <strong class="{{ $transaction->sisa_pembayaran > 0 ? 'text-danger' : 'text-success' }}">
                        Rp {{ number_format($transaction->sisa_pembayaran,0,',','.') }}
                    </strong>
                </div>

                <a href="{{ route('pembayaran', $transaction->id) }}"
                  class="btn-history-detail">

                    <i class="fa-solid fa-receipt"></i>

                    {{ strtolower($paymentStatus) === 'paid'
                        ? 'Lihat Detail'
                        : 'Bayar DP'
                    }}

                </a>

            </div>
              </article>
            @endforeach
          </div>

          <div class="mt-4 d-flex justify-content-center">
            {{ $transactions->onEachSide(1)->links('pagination::bootstrap-5') }}
          </div>
        @endif
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
