@extends('Admin.layout')

@section('title', 'Detail Booking')

@section('content')
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div class="stat-icon" style="--stat-color:#fef3c7;--stat-text:#92400e;"><i class="fa-solid fa-calendar-check"></i></div>
                    <div>
                        <h5 class="section-title">Informasi Booking #{{ $reservation->id }}</h5>
                        <div class="section-subtitle">Detail customer, fasilitas, dan waktu main.</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <tr><th width="180">Customer</th><td>{{ $reservation->transaction->user->nama ?? $reservation->transaction->user->name }}</td></tr>
                        <tr><th>Email</th><td>{{ $reservation->transaction->user->email }}</td></tr>
                        <tr><th>No HP</th><td>{{ $reservation->transaction->user->no_hp ?? '-' }}</td></tr>
                        <tr><th>Fasilitas</th><td>{{ $reservation->facility->nama_fasilitas }}</td></tr>
                        <tr><th>Jenis</th><td>{{ $reservation->facility->jenis }}</td></tr>
                        <tr><th>Waktu</th><td>{{ $reservation->waktu_mulai->format('d M Y H:i') }} - {{ $reservation->waktu_selesai->format('H:i') }}</td></tr>
                        <tr><th>Subtotal</th><td class="fw-bold">Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</td></tr>
                        <tr><th>Status Booking</th><td><span class="badge-soft badge-{{ strtolower($reservation->status_main) }}">{{ $reservation->status_main }}</span></td></tr>
                        <tr><th>Metode Pembayaran</th><td><span class="badge-soft badge-booking">{{ $reservation->transaction->metode_pembayaran ?? 'Pay On Place' }}</span></td></tr>
                        <tr><th>Status Pembayaran</th><td><span class="badge-soft {{ $reservation->transaction->status_pembayaran === 'Paid' ? 'badge-completed' : ($reservation->transaction->status_pembayaran === 'Pending' ? 'badge-booking' : 'badge-cancelled') }}">{{ $reservation->transaction->status_pembayaran }}</span></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card content-card">
            <div class="card-body p-4">
                <h5 class="section-title">Update Status</h5>
                <div class="section-subtitle mb-3">Ubah status booking dan pembayaran customer.</div>
                <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Booking</label>
                        <select name="status_main" class="form-select">
                            @foreach(['Booking','Cancelled','Completed'] as $status)
                                <option value="{{ $status }}" {{ $reservation->status_main === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-warning rounded-4">
                        <i class="fa-solid fa-money-bill-wave me-2"></i>
                        Metode pembayaran: <strong>{{ $reservation->transaction->metode_pembayaran ?? 'Pay On Place' }}</strong>.
                        @php
                            $metodePembayaran = strtolower($reservation->transaction->metode_pembayaran ?? 'pay on place');
                        @endphp
                        @if(str_contains($metodePembayaran, 'qris') || str_contains($metodePembayaran, 'gopay'))
                            Jika pembayaran online sudah masuk, ubah status pembayaran menjadi <strong>Paid</strong>.
                        @else
                            Jika customer sudah bayar cash setelah bermain, ubah status pembayaran menjadi <strong>Paid</strong>.
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-select">
                            @foreach(['Pending','Paid','Cancelled'] as $status)
                                <option value="{{ $status }}" {{ $reservation->transaction->status_pembayaran === $status ? 'selected' : '' }}>{{ $status }}</option>
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
