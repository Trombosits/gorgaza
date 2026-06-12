@extends('Admin.layout')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="card content-card mb-4">
    <div class="card-body p-4">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.reports.finance') }}">
            <div class="col-md-6 col-lg-2">
                <label class="form-label fw-bold">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
            </div>
            <div class="col-md-6 col-lg-2">
                <label class="form-label fw-bold">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label fw-bold">Status Pembayaran</label>
                <select name="status_pembayaran" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach(['Paid','Pending','Cancelled'] as $item)
                        <option value="{{ $item }}" {{ $status === $item ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-3">
                <label class="form-label fw-bold">Metode</label>
                <select name="metode_pembayaran" class="form-select">
                    <option value="">Semua Metode</option>
                    @foreach(['QRIS','Cash / Bayar di Tempat','Pay On Place'] as $item)
                        <option value="{{ $item }}" {{ ($method ?? '') === $item ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-1 d-flex gap-2">
                <button class="btn btn-gaza rounded-4 w-100" title="Filter"><i class="fa-solid fa-filter"></i></button>
            </div>
            <div class="col-md-6 col-lg-1 d-flex gap-2">
                <a href="{{ route('admin.reports.finance') }}" class="btn btn-soft rounded-4 w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#dcfce7;--stat-text:#166534;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Pendapatan Paid</div><div class="stat-value fs-4">Rp {{ number_format($paidRevenue, 0, ',', '.') }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-sack-dollar"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#fef3c7;--stat-text:#92400e;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Tagihan Pending</div><div class="stat-value fs-4">Rp {{ number_format($pendingRevenue, 0, ',', '.') }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-hourglass-half"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#fee2e2;--stat-text:#991b1b;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Cancelled</div><div class="stat-value fs-4">Rp {{ number_format($cancelledRevenue, 0, ',', '.') }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-ban"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card card-stat p-4" style="--stat-color:#dbeafe;--stat-text:#1d4ed8;">
            <div class="d-flex justify-content-between align-items-start">
                <div><div class="stat-label">Total Transaksi</div><div class="stat-value">{{ $transactionCount }}</div></div>
                <div class="stat-icon"><i class="fa-solid fa-receipt"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-4">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <h5 class="section-title">Rekap Status Pembayaran</h5>
                <div class="section-subtitle mb-3">Jumlah transaksi dan nominal berdasarkan status.</div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Status</th><th>Transaksi</th><th>Nominal</th></tr></thead>
                        <tbody>
                            @forelse($paymentStatusSummary as $row)
                                <tr>
                                    <td><span class="badge-soft {{ $row->status_pembayaran === 'Paid' ? 'badge-completed' : ($row->status_pembayaran === 'Pending' ? 'badge-booking' : 'badge-cancelled') }}">{{ $row->status_pembayaran }}</span></td>
                                    <td class="fw-bold">{{ $row->total }}</td>
                                    <td class="fw-bold">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <h5 class="section-title">Rekap Metode Pembayaran</h5>
                <div class="section-subtitle mb-3">Perbandingan QRIS dan cash.</div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Metode</th><th>Transaksi</th><th>Nominal</th></tr></thead>
                        <tbody>
                            @forelse($paymentMethodSummary as $row)
                                <tr>
                                    <td><span class="badge-soft badge-booking">{{ preg_replace(['/QRIS\s*\/\s*Go\s*Pay/i', '/QRIS\/Go\s*Pay/i', '/Go\s*Pay/i'], 'QRIS', $row->metode_pembayaran ?? 'Pay On Place') }}</span></td>
                                    <td class="fw-bold">{{ $row->total }}</td>
                                    <td class="fw-bold">Rp {{ number_format($row->nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card content-card h-100">
            <div class="card-body p-4">
                <h5 class="section-title">Pendapatan per Fasilitas</h5>
                <div class="section-subtitle mb-3">Dihitung dari transaksi dengan pembayaran Paid.</div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Fasilitas</th><th>Total Booking</th><th>Pendapatan</th></tr></thead>
                        <tbody>
                            @forelse($facilityRevenue as $row)
                                <tr>
                                    <td class="fw-bold">{{ $row->nama_fasilitas }}</td>
                                    <td>{{ $row->total_booking }}</td>
                                    <td class="fw-bold">Rp {{ number_format($row->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada pendapatan paid.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card content-card mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Pendapatan Harian</h5>
                <div class="section-subtitle">Ringkasan revenue paid per hari pada rentang filter.</div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Tanggal</th><th>Total Pendapatan Paid</th></tr></thead>
                <tbody>
                    @forelse($dailyRevenue as $row)
                        <tr>
                            <td>{{ \Illuminate\Support\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                            <td class="fw-bold">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted py-4">Belum ada pendapatan harian.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Detail Transaksi</h5>
                <div class="section-subtitle">Daftar transaksi berdasarkan filter laporan keuangan.</div>
            </div>
            <a href="{{ route('admin.reports.finance.export', request()->query()) }}" class="btn btn-gaza rounded-4">
                <i class="fa-solid fa-file-csv me-2"></i>Export CSV
            </a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>ID</th><th>Tanggal</th><th>Customer</th><th>Booking</th><th>Metode</th><th>Status</th><th>Total</th></tr></thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="fw-bold">#{{ $transaction->id }}</td>
                            <td>{{ optional($transaction->waktu_transaksi)->format('d M Y H:i') ?? '-' }}</td>
                            <td>
                                <div class="fw-bold">{{ $transaction->user->nama ?? $transaction->user->name ?? '-' }}</div>
                                <small class="text-muted">{{ $transaction->user->email ?? '-' }}</small>
                            </td>
                            <td>
                                @forelse($transaction->reservations as $reservation)
                                    <div>{{ $reservation->facility->nama_fasilitas ?? '-' }} <small class="text-muted">({{ $reservation->waktu_mulai->format('d M H:i') }})</small></div>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td><span class="badge-soft badge-booking">{{ $transaction->metode_pembayaran ?? 'Pay On Place' }}</span></td>
                            <td><span class="badge-soft {{ $transaction->status_pembayaran === 'Paid' ? 'badge-completed' : ($transaction->status_pembayaran === 'Pending' ? 'badge-booking' : 'badge-cancelled') }}">{{ $transaction->status_pembayaran }}</span></td>
                            <td class="fw-bold">Rp {{ number_format($transaction->total_tagihan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7"><div class="empty-state"><i class="fa-solid fa-file-invoice-dollar"></i><div>Belum ada transaksi pada filter ini.</div></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $transactions->links() }}</div>
    </div>
</div>
@endsection
