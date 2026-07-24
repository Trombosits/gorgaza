@extends('Admin.layout')

@section('title', 'Beranda Admin')

@section('content')
@php
    $statusLabels = [
        'Booking' => 'Menunggu',
        'Confirmed' => 'Disetujui',
        'Completed' => 'Selesai',
        'Cancelled' => 'Dibatalkan',
        'Out of Time' => 'Selesai',
    ];
    $paymentLabels = [
        'Paid' => 'Lunas',
        'Pending' => 'Menunggu',
        'Cancelled' => 'Dibatalkan',
    ];
@endphp

<div class="card content-card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold">
                Halo Admin 👋
            </h3>
            <div class="text-muted">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
        <div class="text-end">
            <span class="badge bg-success fs-6">
                Website Online
            </span>
            <br>
            <span class="badge bg-primary mt-2">
                Booking Aktif
            </span>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#dbeafe;--stat-text:#1d4ed8;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Pelanggan</div><div class="stat-value">{{ $totalUsers }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#dcfce7;--stat-text:#166534;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Fasilitas Aktif</div><div class="stat-value">{{ $totalFacilities }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-building"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#fef3c7;--stat-text:#92400e;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total Pemesanan</div><div class="stat-value">{{ $totalReservations }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#fee2e2;--stat-text:#991b1b;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Pendapatan Lunas</div><div class="stat-value fs-4">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-wallet"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="section-title">Ringkasan Operasional</h5>
                        <div class="section-subtitle">Status pemesanan dan pembayaran saat ini.</div>
                    </div>
                    <a href="{{ route('admin.reports.finance') }}" class="btn btn-gaza rounded-4 px-3">
                        <i class="fa-solid fa-chart-line me-2"></i>Lihat Laporan
                    </a>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 bg-light border">
                            <small class="text-muted fw-bold">Pemesanan Hari Ini</small>
                            <h4 class="fw-bold mt-2 mb-0">{{ $todayReservations }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 bg-light border">
                            <small class="text-muted fw-bold">Pendapatan Bulan Ini</small>
                            <h4 class="fw-bold mt-2 mb-0">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 bg-light border">
                            <small class="text-muted fw-bold">Tagihan Menunggu</small>
                            <h4 class="fw-bold mt-2 mb-0">Rp {{ number_format($pendingPayments, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 border h-100">
                            <div class="fw-bold mb-3">Status Pemesanan</div>
                            @foreach(['Booking','Confirmed','Completed','Cancelled'] as $status)
                                @php($total = $statusSummary[$status] ?? 0)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge-soft badge-{{ strtolower(str_replace(' ', '-', $status)) }}">{{ $statusLabels[$status] ?? $status }}</span>
                                    <strong>{{ $total }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 border h-100">
                            <div class="fw-bold mb-3">Status Pembayaran</div>
                            @foreach(['Paid','Pending','Cancelled'] as $status)
                                @php($total = $paymentSummary[$status] ?? 0)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge-soft {{ $status === 'Paid' ? 'badge-completed' : ($status === 'Pending' ? 'badge-booking' : 'badge-cancelled') }}">{{ $paymentLabels[$status] ?? $status }}</span>
                                    <strong>{{ $total }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <h5 class="section-title">Shortcut Admin</h5>
                <div class="section-subtitle mb-3">Akses cepat untuk pekerjaan harian.</div>
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-soft rounded-4 text-start py-3"><i class="fa-solid fa-calendar-check me-2 text-warning"></i> Kelola Pemesanan</a>
                    <a href="{{ route('admin.facilities.create') }}" class="btn btn-soft rounded-4 text-start py-3"><i class="fa-solid fa-plus me-2 text-success"></i> Tambah Fasilitas</a>
                    <a href="{{ route('admin.reports.finance') }}" class="btn btn-soft rounded-4 text-start py-3"><i class="fa-solid fa-file-invoice-dollar me-2 text-primary"></i> Laporan Keuangan</a>
                    <a href="/" target="_blank" class="btn btn-soft rounded-4 text-start py-3"><i class="fa-solid fa-globe me-2 text-info"></i> Buka Website</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    {{-- Badminton --}}
    <div class="col-lg-4">
        <div class="card content-card h-100 shadow-sm">
            <div class="card-body text-center">
                <div class="display-5 text-success mb-3">
                    <i class="fa-solid fa-table-tennis-paddle-ball"></i>
                </div>
                <h5 class="fw-bold">
                    Badminton
                </h5>
                <h3 class="text-success fw-bold mt-3">
                    Rp {{ number_format($badminton->harga_per_jam,0,',','.') }}
                </h3>
                <small class="text-muted">
                    per jam
                </small>
                <hr>
                <span class="badge bg-success">
                    Aktif
                </span>
            </div>
        </div>
    </div>

    {{-- Billiard --}}
    <div class="col-lg-4">
        <div class="card content-card h-100 shadow-sm">
            <div class="card-body text-center">
                <div class="display-5 text-danger mb-3">
                    <i class="fa-solid fa-circle-dot"></i>
                </div>
                <h5 class="fw-bold">
                    Billiard
                </h5>
                @if($billiard->harga_promo)
                    <h3 class="text-danger fw-bold mt-3">
                        Rp {{ number_format($billiard->harga_promo,0,',','.') }}
                    </h3>
                    <small class="text-decoration-line-through text-secondary">
                        Rp {{ number_format($billiard->harga_per_jam,0,',','.') }}
                    </small>
                    <div class="mt-3">
                        <span class="badge bg-warning text-dark">
                            🔥 Promo
                        </span>
                    </div>
                    <small class="text-muted d-block mt-2">
                        {{ \Carbon\Carbon::parse($billiard->promo_mulai)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($billiard->promo_selesai)->format('H:i') }}
                    </small>
                @else
                    <h3 class="text-danger fw-bold mt-3">
                        Rp {{ number_format($billiard->harga_per_jam,0,',','.') }}
                    </h3>
                    <small class="text-muted">
                        per jam
                    </small>
                @endif
            </div>
        </div>
    </div>
    {{-- Booking Selanjutnya --}}
    <div class="col-lg-4">
        <div class="card content-card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold mb-4">
                    <i class="fa-solid fa-calendar-days me-2"></i>
                    Booking Selanjutnya
                </h5>
                @if($nextBooking)
                    <div class="display-6 fw-bold text-primary">
                        {{ $nextBooking->waktu_mulai->format('H:i') }}
                    </div>
                    <div class="mt-3">
                        <strong>
                            {{ $nextBooking->facility->nama_fasilitas }}
                        </strong>
                    </div>
                    <div class="text-muted">
                        {{ $nextBooking->transaction->user->nama }}
                    </div>
                    <span class="badge bg-success mt-3">
                        {{ $nextBooking->status_main }}
                    </span>
                @else
                    <div class="text-center py-4">
                        <i class="fa-regular fa-calendar-xmark display-5 text-secondary mb-3"></i>
                        <p class="mb-0">
                            Belum ada booking berikutnya
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <h5 class="section-title">
                    <i class="fa-solid fa-sliders me-2"></i>
                    Konfigurasi Sistem
                </h5>
                <div class="section-subtitle mb-3">
                    Pengaturan yang sedang digunakan sistem booking.
                </div>
                <table class="table align-middle">
                    <tr>
                        <td width="45%">
                            Nominal DP
                        </td>
                        <td>
                            <strong>
                                Rp {{ number_format($setting->nominal_dp,0,',','.') }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Jam Operasional</td>
                        <td>
                            {{ \Carbon\Carbon::parse($setting->jam_buka)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($setting->jam_tutup)->format('H:i') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <h5 class="section-title">
                    <i class="fa-solid fa-tags me-2"></i>
                    Harga Fasilitas
                </h5>
                <div class="section-subtitle mb-3">
                    Harga yang sedang digunakan saat ini.
                </div>
                <table class="table align-middle">
                    <tr>
                        <td>Badminton</td>
                        <td>
                            Rp {{ number_format($badminton->harga_per_jam,0,',','.') }}
                        </td>
                    </tr>
                    <tr>
                        <td>Billiard</td>
                        <td>
                            @if($billiard->harga_promo)
                                <div class="text-decoration-line-through text-secondary">
                                    Rp {{ number_format($billiard->harga_per_jam,0,',','.') }}
                                </div>
                                <strong class="text-success">
                                    Rp {{ number_format($billiard->harga_promo,0,',','.') }}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    Promo
                                    {{ \Carbon\Carbon::parse($billiard->promo_mulai)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($billiard->promo_selesai)->format('H:i') }}
                                </small>
                            @else
                                Rp {{ number_format($billiard->harga_per_jam,0,',','.') }}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Pemesanan Terbaru</h5>
                <div class="section-subtitle">Data pemesanan terakhir yang masuk ke sistem.</div>
            </div>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-soft rounded-4">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Pelanggan</th><th>Fasilitas</th><th>Waktu</th><th>Status</th><th>Pembayaran</th><th>Total</th></tr></thead>
                <tbody>
                @forelse($latestReservations as $reservation)
                    @php($payment = $reservation->transaction->status_pembayaran ?? '-')
                    @php($statusClass = strtolower(str_replace(' ', '-', $reservation->status_main)))
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $reservation->transaction->user->nama ?? $reservation->transaction->user->name ?? '-' }}</div>
                            <small class="text-muted">{{ $reservation->transaction->user->email ?? '-' }}</small>
                        </td>
                        <td>{{ $reservation->facility->nama_fasilitas ?? '-' }}</td>
                        <td>{{ $reservation->waktu_mulai->format('d M Y H:i') }} - {{ $reservation->waktu_selesai->format('H:i') }}</td>
                        <td><span class="badge-soft badge-{{ $statusClass }}">{{ $statusLabels[$reservation->status_main] ?? $reservation->status_main }}</span></td>
                        <td><span class="badge-soft {{ $payment === 'Paid' ? 'badge-completed' : ($payment === 'Pending' ? 'badge-booking' : 'badge-cancelled') }}">{{ $paymentLabels[$payment] ?? $payment }}</span></td>
                        <td class="fw-bold">Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="empty-state"><i class="fa-regular fa-calendar-xmark"></i><div>Belum ada pemesanan.</div></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
