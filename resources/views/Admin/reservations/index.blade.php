@extends('Admin.layout')

@section('title', 'Kelola Booking')

@section('content')
<div class="card content-card mb-3">
    <div class="card-body">
        <form class="row g-2">
            <div class="col-md-4">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['Booking','Confirmed','Cancelled','Completed'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button class="btn btn-warning">Filter</button>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card content-card">
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead><tr><th>ID</th><th>Customer</th><th>Fasilitas</th><th>Waktu</th><th>Status</th><th>Pembayaran</th><th>Total</th><th width="190">Aksi</th></tr></thead>
            <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td>#{{ $reservation->id }}</td>
                    <td>{{ $reservation->transaction->user->nama ?? $reservation->transaction->user->name ?? '-' }}</td>
                    <td>{{ $reservation->facility->nama_fasilitas ?? '-' }}</td>
                    <td>{{ $reservation->waktu_mulai->format('d M Y H:i') }} - {{ $reservation->waktu_selesai->format('H:i') }}</td>
                    <td><span class="badge bg-warning text-dark">{{ $reservation->status_main }}</span></td>
                    <td>{{ $reservation->transaction->status_pembayaran }}</td>
                    <td>Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-primary">Detail</a>
                        <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus booking ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">Belum ada booking.</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $reservations->links() }}
    </div>
</div>
@endsection
