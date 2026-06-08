@extends('Admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card card-stat p-3"><span class="text-muted">Customer</span><h3>{{ $totalUsers }}</h3></div></div>
    <div class="col-md-3"><div class="card card-stat p-3"><span class="text-muted">Fasilitas</span><h3>{{ $totalFacilities }}</h3></div></div>
    <div class="col-md-3"><div class="card card-stat p-3"><span class="text-muted">Total Booking</span><h3>{{ $totalReservations }}</h3></div></div>
    <div class="col-md-3"><div class="card card-stat p-3"><span class="text-muted">Revenue Paid</span><h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3></div></div>
</div>

<div class="card content-card">
    <div class="card-header bg-white fw-bold">Booking Terbaru</div>
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Customer</th><th>Fasilitas</th><th>Waktu</th><th>Status</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($latestReservations as $reservation)
                <tr>
                    <td>{{ $reservation->transaction->user->nama ?? $reservation->transaction->user->name ?? '-' }}</td>
                    <td>{{ $reservation->facility->nama_fasilitas ?? '-' }}</td>
                    <td>{{ $reservation->waktu_mulai->format('d M Y H:i') }} - {{ $reservation->waktu_selesai->format('H:i') }}</td>
                    <td><span class="badge bg-warning text-dark">{{ $reservation->status_main }}</span></td>
                    <td>Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada booking.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
