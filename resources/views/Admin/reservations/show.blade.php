@extends('Admin.layout')

@section('title', 'Detail Booking')

@section('content')
<div class="row g-3">
    <div class="col-md-7">
        <div class="card content-card">
            <div class="card-header bg-white fw-bold">Informasi Booking</div>
            <div class="card-body">
                <table class="table">
                    <tr><th>ID Booking</th><td>#{{ $reservation->id }}</td></tr>
                    <tr><th>Customer</th><td>{{ $reservation->transaction->user->nama ?? $reservation->transaction->user->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $reservation->transaction->user->email }}</td></tr>
                    <tr><th>No HP</th><td>{{ $reservation->transaction->user->no_hp ?? '-' }}</td></tr>
                    <tr><th>Fasilitas</th><td>{{ $reservation->facility->nama_fasilitas }}</td></tr>
                    <tr><th>Waktu</th><td>{{ $reservation->waktu_mulai->format('d M Y H:i') }} - {{ $reservation->waktu_selesai->format('H:i') }}</td></tr>
                    <tr><th>Subtotal</th><td>Rp {{ number_format($reservation->subtotal, 0, ',', '.') }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card content-card">
            <div class="card-header bg-white fw-bold">Update Status</div>
            <div class="card-body">
                <form action="{{ route('admin.reservations.updateStatus', $reservation) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label">Status Main</label>
                        <select name="status_main" class="form-select">
                            @foreach(['Booking','Confirmed','Cancelled','Completed'] as $status)
                                <option value="{{ $status }}" {{ $reservation->status_main === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status_pembayaran" class="form-select">
                            @foreach(['Pending','Paid','Cancelled'] as $status)
                                <option value="{{ $status }}" {{ $reservation->transaction->status_pembayaran === $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-warning">Simpan Status</button>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
