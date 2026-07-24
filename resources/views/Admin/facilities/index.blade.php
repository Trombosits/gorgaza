@extends('Admin.layout')

@section('title', 'Kelola Fasilitas')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Data Fasilitas</h5>
                <div class="section-subtitle">Kelola fasilitas yang bisa dipesan pelanggan.</div>
            </div>
            <a href="{{ route('admin.facilities.create') }}" class="btn btn-gaza rounded-4"><i class="fa-solid fa-plus me-2"></i>Tambah Fasilitas</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Nama</th><th>Jenis</th><th>Harga/Jam</th><th>Status</th><th width="160">Aksi</th></tr></thead>
                <tbody>
                @forelse($facilities as $facility)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $facility->nama_fasilitas }}</div>
                            <small class="text-muted">{{ $facility->deskripsi ?: 'Tanpa deskripsi' }}</small>
                        </td>
                        <td>
                            {{ $facility->jenis }}
                            @if($facility->jenis === 'Cafe')
                                <div><small class="text-muted">Belum tampil di halaman pelanggan</small></div>
                            @endif
                        </td>
                       <td>

                            Rp {{ number_format($facility->harga_per_jam,0,',','.') }}

                            @if($facility->harga_promo)

                                <br>

                                <span class="badge bg-success mt-1">

                                    Promo
                                    Rp {{ number_format($facility->harga_promo,0,',','.') }}

                                </span>
                                @if($facility->promo_mulai)

                            <div class="small text-muted">

                            {{ \Carbon\Carbon::parse($facility->promo_mulai)->format('H:i') }}

                            -

                            {{ \Carbon\Carbon::parse($facility->promo_selesai)->format('H:i') }}

                            </div>

                            @endif
                             @endif

                        </td>
                        <td>
    @if($facility->is_active)
        <span class="badge bg-success">
            Aktif
        </span>
    @else
        <span class="badge bg-secondary">
            Nonaktif
        </span>
    @endif
</td>

                        <td>
                            <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-sm btn-soft rounded-3"><i class="fa-solid fa-pen"></i></a>
                            <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus fasilitas ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger rounded-3"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5"><div class="empty-state"><i class="fa-solid fa-building"></i><div>Belum ada fasilitas.</div></div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
