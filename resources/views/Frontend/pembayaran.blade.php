<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Booking #{{ $transaction->id }} - GOR GAZA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
</head>
<body class="payment-page">
    @php
        $metode = $transaction->metode_pembayaran ?? 'Pay On Place';
        $isOnline = str_contains(strtolower($metode), 'qris') || str_contains(strtolower($metode), 'gopay') || str_contains(strtolower($metode), 'online');
        $whatsappText = rawurlencode('Halo Admin GOR GAZA, saya ingin konfirmasi booking dengan ID Transaksi #' . $transaction->id . ' sebesar Rp ' . number_format($transaction->total_tagihan, 0, ',', '.') . ' menggunakan metode ' . $metode . '.');
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand" href="/">GOR GAZA</a>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; max-width: 860px;">
        <div class="payment-panel shadow-sm border-0 p-4 p-lg-5">
            <div class="text-center mb-4">
                <div class="payment-header-icon"><i class="fas fa-wallet"></i></div>
                <h3 class="fw-bold mt-3 mb-2">Halaman Pembayaran</h3>
                <p class="text-muted mb-0">Selesaikan pembayaran sesuai metode yang dipilih untuk proses konfirmasi booking.</p>
            </div>

            <div class="payment-summary-card mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>ID Transaksi:</strong> #{{ $transaction->id }}</p>
                        <p class="mb-1"><strong>Nama Customer:</strong> {{ $transaction->user->nama ?? $transaction->user->name }}</p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning text-dark">{{ $transaction->status_pembayaran }}</span></p>
                        <p class="mb-0"><strong>Metode:</strong> <span class="badge bg-info text-dark">{{ $metode }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-warning mb-2">Detail Booking</h6>
                        @foreach($transaction->reservations as $reservation)
                            <p class="mb-1">
                                <i class="fas fa-calendar-check me-2"></i>{{ $reservation->facility->nama_fasilitas }}
                                ({{ \Carbon\Carbon::parse($reservation->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->waktu_selesai)->format('H:i') }} WIB)
                            </p>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="text-center mb-4">
                <h6 class="text-uppercase text-muted tracking-wide mb-1">Total yang Harus Dibayar</h6>
                <h2 class="text-warning fw-bold">Rp {{ number_format($transaction->total_tagihan, 0, ',', '.') }}</h2>
            </div>

            @if($isOnline)
                <div class="qris-payment-box mb-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5 text-center">
                            <img src="{{ asset('images/payment/qris-gorgaza.jpeg') }}" alt="QRIS GOR GAZA" class="qris-image">
                        </div>
                        <div class="col-lg-7">
                            <h5 class="fw-bold mb-2"><i class="fa-solid fa-qrcode me-2"></i>Bayar Online QRIS / GoPay</h5>
                            <p class="mb-3">Silakan scan QR di samping menggunakan aplikasi pembayaran yang mendukung QRIS/GoPay.</p>
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-circle-info me-2"></i>
                                Setelah melakukan pembayaran, hubungi admin untuk konfirmasi. Admin akan mengubah status pembayaran menjadi <strong>Paid</strong> setelah dana diterima.
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="cash-payment-box mb-4">
                    <h5 class="fw-bold mb-2"><i class="fas fa-store me-2"></i>Cash / Bayar di Tempat</h5>
                    <p class="mb-2">Booking kamu sudah tercatat dengan status pembayaran <strong>Pending</strong>.</p>
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-circle-info me-2"></i>
                        Untuk pembayaran cash, silakan bayar langsung ke admin/kasir setelah bermain. Admin akan mengubah status pembayaran menjadi <strong>Paid</strong> setelah pembayaran diterima.
                    </div>
                </div>
            @endif

            <div class="d-grid gap-2">
                <a href="https://wa.me/6282215309779?text={{ $whatsappText }}" target="_blank" class="btn btn-success btn-lg rounded-pill">
                    <i class="fab fa-whatsapp me-2"></i>Konfirmasi ke Admin via WhatsApp
                </a>
                <a href="/" class="btn btn-outline-dark rounded-pill mt-2">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</body>
</html>
