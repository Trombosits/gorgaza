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
<body>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark mb-5">
        <div class="container">
            <a class="navbar-brand" href="/">GOR GAZA</a>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px; max-width: 700px;">
        <div class="card shadow-sm border-0 bg-dark text-white p-4">
            <div class="card-body text-center">
                <i class="fas fa-wallet text-warning fa-3x mb-3"></i>
                <h3 class="card-title fw-bold">Halaman Pembayaran</h3>
                <p class="text-muted text-light">Selesaikan pembayaran Anda untuk mengunci jadwal lapangan.</p>
                <hr class="border-secondary">

                <div class="text-start bg-secondary bg-opacity-25 p-3 rounded mb-4">
                    <p class="mb-1"><strong>ID Transaksi:</strong> #{{ $transaction->id }}</p>
                    <p class="mb-1"><strong>Nama Customer:</strong> {{ $transaction->user->nama ?? $transaction->user->name }}</p>
                    <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning text-dark">{{ $transaction->status_pembayaran }}</span></p>
                    
                    <hr class="border-secondary">
                    <h5 class="fw-bold text-warning mb-2">Detail Lapangan:</h5>
                    @foreach($transaction->reservations as $reservation)
                        <p class="mb-1">
                            <i class="fas fa-table-tennis me-2"></i>{{ $reservation->facility->nama_fasilitas }} 
                            ({{ \Carbon\Carbon::parse($reservation->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->waktu_selesai)->format('H:i') }} WIB)
                        </p>
                    @endforeach
                </div>

                <div class="mb-4">
                    <h6 class="text-uppercase text-muted tracking-wide mb-1">Total yang Harus Dibayar</h6>
                    <h2 class="text-warning fw-bold">Rp {{ number_format($transaction->total_tagihan, 0, ',', '.') }}</h2>
                </div>

                <div class="bg-light text-dark rounded p-3 text-start mb-4">
                    <h6 class="fw-bold mb-2 text-center"><i class="fas fa-university me-2"></i>Rekening Transfer Resmi GOR GAZA</h6>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><strong>Bank BCA:</strong></span>
                        <span class="fw-bold text-primary">1234-567-890 <small class="text-muted">(a.n GOR GAZA)</small></span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span><strong>DANA / OVO:</strong></span>
                        <span class="fw-bold text-success">0812-3456-7890 <small class="text-muted">(GOR GAZA)</small></span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20GOR%20GAZA,%20saya%20ingin%20konfirmasi%20pembayaran%20booking%20dengan%20ID%20Transaksi%20%23{{ $transaction->id }}%20sebesar%20Rp%20{{ number_format($transaction->total_tagihan, 0, ',', '.') }}" 
                       target="_blank" 
                       class="btn btn-success btn-lg rounded-pill">
                        <i class="fab fa-whatsapp me-2"></i>Kirim Bukti Transfer ke WhatsApp
                    </a>
                    <a href="/" class="btn btn-outline-light rounded-pill mt-2">Kembali ke Beranda</a>
                </div>

            </div>
        </div>
    </div>

</body>
</html>