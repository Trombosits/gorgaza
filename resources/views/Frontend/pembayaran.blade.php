<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pemesanan #{{ $transaction->id }} - GOR GAZA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
</head>
<body class="payment-page payment-polish-page">
    @php
        $rawMetode = $transaction->metode_pembayaran ?? 'Pay On Place';
        $metode = preg_replace(['/QRIS\s*\/\s*Go\s*Pay/i', '/QRIS\/Go\s*Pay/i', '/Go\s*Pay/i'], 'QRIS', $rawMetode);
        $isOnline = str_contains(strtolower($metode), 'qris') || str_contains(strtolower($metode), 'online');
        $paymentLabels = [
            'Paid' => 'Lunas',
            'Pending' => 'Menunggu',
            'Cancelled' => 'Dibatalkan',
        ];
        $statusPembayaran = $paymentLabels[$transaction->status_pembayaran] ?? $transaction->status_pembayaran;
        $metode = $metode === 'Cash / Bayar di Tempat' || $metode === 'Pay On Place' ? 'Tunai / Bayar di Tempat' : $metode;
        $whatsappText = rawurlencode('Halo Admin GOR GAZA, saya ingin konfirmasi booking dengan ID Transaksi #' . $transaction->id . ' sebesar Rp ' . number_format($transaction->total_tagihan, 0, ',', '.') . ' menggunakan metode ' . $metode . '.');
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand brand-mark" href="/">
          <img src="{{ asset('images/logo-gorgaza.png') }}" alt="GOR GAZA" class="navbar-logo-img">
          <span>GOR GAZA</span>
        </a>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-light rounded-pill px-3" href="/booking-history">Riwayat</a>
                <a class="btn btn-warning rounded-pill px-3 fw-bold" href="/booking">Pemesanan</a>
            </div>
        </div>
    </nav>

    <main class="payment-main-wrap">
        <div class="container" style="max-width: 980px;">
            <div class="payment-panel polished-payment-panel">
                <div class="text-center payment-page-heading">
                    <div class="payment-header-icon"><i class="fas fa-wallet"></i></div>
                    <span class="section-eyebrow mt-3">Pembayaran Pemesanan</span>
                    <h1>Halaman Pembayaran</h1>
                    <p>Selesaikan pembayaran sesuai metode yang dipilih untuk proses konfirmasi pemesanan.</p>
                </div>

                <div class="payment-summary-card polished-summary-card mb-4">
                    <div class="payment-summary-grid">
                        <div>
                            <p class="payment-label">ID Transaksi</p>
                            <h4>#{{ $transaction->id }}</h4>
                        </div>
                        <div>
                            <p class="payment-label">Pelanggan</p>
                            <h4>{{ $transaction->user->nama ?? $transaction->user->name }}</h4>
                        </div>
                        <div>
                            <p class="payment-label">Status</p>
                            <span class="payment-badge {{ strtolower($transaction->status_pembayaran) === 'paid' ? 'paid' : 'pending' }}">{{ $statusPembayaran }}</span>
                        </div>
                        <div>
                            <p class="payment-label">Metode</p>
                            <span class="payment-badge method">{{ $metode }}</span>
                        </div>
                    </div>

                    <div class="payment-booking-detail mt-4">
                        <h5><i class="fa-solid fa-calendar-check me-2"></i>Detail Pemesanan</h5>
                        @foreach($transaction->reservations as $reservation)
                            <div class="payment-booking-row">
                                <span>{{ $reservation->facility->nama_fasilitas }}</span>
                                <strong>{{ \Carbon\Carbon::parse($reservation->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->waktu_selesai)->format('H:i') }} WIB</strong>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="payment-total-box text-center mb-4">
                    <p>Total yang Harus Dibayar</p>
                    <h2>Rp {{ number_format($transaction->total_tagihan, 0, ',', '.') }}</h2>
                </div>

                @if($isOnline)
                    <div class="qris-payment-box polished-qris-box mb-4">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-5 text-center">
                                <div class="qris-frame">
                                    <img src="{{ asset('images/payment/qris-gorgaza.jpeg') }}" alt="QRIS GOR GAZA" class="qris-image">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <span class="payment-mini-label">Metode pembayaran</span>
                                <h5><i class="fa-solid fa-qrcode me-2"></i>Bayar QRIS</h5>
                                <p>Silakan scan QRIS resmi GOR GAZA menggunakan aplikasi pembayaran yang mendukung QRIS.</p>
                                @if(strtolower($transaction->status_pembayaran) === 'paid')
                                  <div class="alert alert-success mb-0 rounded-4">
                                    <i class="fas fa-check-circle me-2"></i>
                                    Pembayaran sudah dikonfirmasi admin dan status transaksi kamu sudah <strong>Lunas</strong>.
                                  </div>
                                @else
                                  <div class="alert alert-warning mb-0 rounded-4">
                                    <i class="fas fa-circle-info me-2"></i>
                                    Setelah melakukan pembayaran, hubungi admin untuk konfirmasi. Admin akan mengubah status pembayaran menjadi <strong>Lunas</strong> setelah dana diterima.
                                  </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="cash-payment-box polished-cash-box mb-4">
                        <div class="cash-icon"><i class="fas fa-store"></i></div>
                        <div>
                            <span class="payment-mini-label">Metode pembayaran</span>
                            <h5>Tunai / Bayar di Tempat</h5>
                            <p>Pemesanan kamu sudah tercatat dengan status pembayaran <strong>Menunggu</strong>. Silakan bayar langsung ke admin/kasir GOR GAZA sesuai total tagihan.</p>
                            @if(strtolower($transaction->status_pembayaran) === 'paid')
                              <div class="alert alert-success mb-0 rounded-4">
                                <i class="fas fa-check-circle me-2"></i>
                                Pembayaran tunai sudah dikonfirmasi admin dan status transaksi kamu sudah <strong>Lunas</strong>.
                              </div>
                            @else
                              <div class="alert alert-warning mb-0 rounded-4">
                                <i class="fas fa-circle-info me-2"></i>
                                Admin akan mengubah status pembayaran menjadi <strong>Lunas</strong> setelah pembayaran diterima.
                              </div>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="payment-action-grid">
                    <a href="https://wa.me/6282215309779?text={{ $whatsappText }}" target="_blank" rel="noopener" class="btn-payment-whatsapp">
                        <i class="fab fa-whatsapp me-2"></i>Konfirmasi ke Admin via WhatsApp
                    </a>
                    <a href="/booking-history" class="btn-payment-home"><i class="fa-solid fa-clock-rotate-left me-2"></i>Riwayat Pemesanan</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
