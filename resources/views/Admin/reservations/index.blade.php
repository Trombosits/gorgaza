@extends('Admin.layout')

@section('title', 'Kelola Booking')

@section('content')
<div class="card content-card mb-4">
    <div class="card-body p-4">
        <form class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tanggal Booking</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Status Booking</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['Booking','Confirmed','Cancelled','Completed'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button class="btn btn-gaza rounded-4 flex-fill"><i class="fa-solid fa-filter me-2"></i>Filter</button>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-soft rounded-4">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Data Booking</h5>
                <div class="section-subtitle">Kelola jadwal main, status booking, dan pembayaran customer.</div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>ID</th><th>Customer</th><th>Fasilitas</th><th>Waktu</th><th>Status</th><th>Pembayaran</th><th>Total</th><th width="190">Aksi</th></tr></thead>
                <tbody>
                @forelse($reservations as $reservation)
                    @php($payment = $reservation->transaction->status_pembayaran ?? '-')
                    <tr>
                        <td class="fw-bold">#{{ $reservation->id }}</td>
                        <td>
                            <div class="fw-bold">{{ $reservation->transaction->user->nama ?? $reservation->transaction->user->name ?? '-' }}</div>
                            <small class="text-muted">{{ $reservation->transaction->user->email ?? '-' }}</small>
                        </td>
                        <td>{{ $reservation->facility->nama_fasilitas ?? '-' }}</td>
                        <td>{{ $reservation->waktu_mulai->format('d M Y H:i') }} - {{ $reservation->waktu_selesai->format('H:i') }}</td>
                        <td><span class="badge-soft badge-{{ strtolower($reservation->status_main) }}">{{ $reservation->status_main }}</span></td>
                        <td><span class="badge-soft {{ $payment === 'Paid' ? 'badge-completed' : ($payment === 'Pending' ? 'badge-booking' : 'badge-cancelled') }}">{{ $payment }}</span></td>
                        <td class="fw-bold">Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-soft rounded-3"><i class="fa-solid fa-eye"></i></a>
                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus booking ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger rounded-3"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8"><div class="empty-state"><i class="fa-regular fa-calendar-xmark"></i><div>Belum ada booking.</div></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $reservations->links() }}</div>
    </div>
</div>
@endsection
