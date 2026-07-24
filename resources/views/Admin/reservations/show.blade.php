@extends('Admin.layout')

@section('title', 'Detail Pemesanan')

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
        'Partial' => 'DP Diterima',
        'Pending' => 'Menunggu DP',
        'Cancelled' => 'Dibatalkan',
    ];
    $methodLabels = [
        'QRIS' => 'QRIS',
        'Cash / Bayar di Tempat' => 'Tunai / Bayar di Tempat',
        'Pay On Place' => 'Tunai / Bayar di Tempat',
    ];
    $cleanMethod = function ($method) use ($methodLabels) {
        $method = preg_replace(['/QRIS\s*\/\s*Go\s*Pay/i', '/QRIS\/Go\s*Pay/i', '/Go\s*Pay/i'], 'QRIS', $method ?? 'Bayar di Tempat');
        return $methodLabels[$method] ?? $method;
    };
@endphp
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="stat-icon" style="--stat-color:#fef3c7;--stat-text:#92400e;"><i class="fa-solid fa-calendar-check"></i></div>
                    <div>
                        <h5 class="section-title">Informasi Pemesanan #{{ $reservation->id }}</h5>
                        <div class="section-subtitle">Detail pelanggan, fasilitas, dan waktu main.</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <tr><th width="180">Pelanggan</th><td>{{ $reservation->transaction->user->nama ?? $reservation->transaction->user->name }}</td></tr>
                        <tr><th>Email</th><td>{{ $reservation->transaction->user->email }}</td></tr>
                        <tr><th>No HP</th><td>{{ $reservation->transaction->user->no_hp ?? '-' }}</td></tr>
                        <tr><th>Fasilitas</th><td>{{ $reservation->facility->nama_fasilitas }}</td></tr>
                        <tr><th>Jenis</th><td>{{ $reservation->facility->jenis }}</td></tr>
                        <tr><th>Waktu</th><td>{{ $reservation->waktu_mulai->format('d M Y H:i') }} - {{ $reservation->waktu_selesai->format('H:i') }}</td></tr>
                        <tr><th>Subtotal</th><td class="fw-bold">Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</td></tr>
                        @php
    $displayStatus = $reservation->status_main === 'Out of Time' ? 'Completed' : $reservation->status_main;
    $statusClass = strtolower(str_replace(' ', '-', $displayStatus));
    $paymentStatus = $reservation->transaction->status_pembayaran ?? 'Pending';
    $paymentMethod = $cleanMethod($reservation->transaction->metode_pembayaran ?? 'Bayar di Tempat');

    $paymentClass = $paymentStatus === 'Paid'
        ? 'badge-completed'
        : ($paymentStatus === 'Pending' ? 'badge-booking' : 'badge-cancelled');
@endphp

<tr>
    <th>Status Pemesanan</th>
    <td>
        <span class="badge-soft badge-{{ $statusClass }}">
            {{ $statusLabels[$displayStatus] ?? $displayStatus }}
        </span>
    </td>
</tr>

<tr>
    <th>Metode Pembayaran</th>
    <td>
        <span class="badge-soft badge-booking">
            {{ $paymentMethod }}
        </span>
    </td>
</tr>

<tr>
    <th>Status Pembayaran</th>
    <td>
        <span class="badge-soft {{ $paymentClass }}">
            {{ $paymentLabels[$paymentStatus] ?? $paymentStatus }}
        </span>
    </td>
</tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card content-card">
            <div class="card-body p-4">
                <h5 class="section-title">Ubah Status</h5>
                <div class="section-subtitle mb-3">Ubah status pemesanan dan pembayaran pelanggan.</div>
                <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Pemesanan</label>
                        <select name="status_main" class="form-select">
                            @foreach(['Booking','Confirmed','Cancelled','Completed'] as $status)
                                <option value="{{ $status }}" {{ $reservation->status_main === $status ? 'selected' : '' }}>{{ $statusLabels[$status] ?? $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-warning rounded-4">
                        <i class="fa-solid fa-money-bill-wave me-2"></i>
                        Metode pembayaran: <strong>{{ $cleanMethod($reservation->transaction->metode_pembayaran ?? 'Bayar di Tempat') }}</strong>.
                        @php
                            $metodePembayaran = strtolower($reservation->transaction->metode_pembayaran ?? 'pay on place');
                        @endphp
                        @if(str_contains($metodePembayaran, 'qris'))
                            Jika pembayaran QRIS sudah masuk, ubah status pembayaran menjadi <strong>Lunas</strong>.
                        @else
                            Jika pelanggan sudah bayar di tempat setelah bermain, ubah status pembayaran menjadi <strong>Lunas</strong>.
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-select">
                            @foreach(['Pending','Partial','Paid','Cancelled'] as $status)
                                <option value="{{ $status }}" {{ $reservation->transaction->status_pembayaran === $status ? 'selected' : '' }}>{{ $paymentLabels[$status] ?? $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-gaza rounded-4 flex-fill"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan</button>
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-soft rounded-4">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
