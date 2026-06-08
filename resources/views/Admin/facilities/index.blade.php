@extends('Admin.layout')

@section('title', 'Kelola Fasilitas')

@section('content')
<div class="card content-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong>Data Fasilitas</strong>
        <a href="{{ route('admin.facilities.create') }}" class="btn btn-warning btn-sm">Tambah Fasilitas</a>
    </div>
    <div class="card-body table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Nama</th><th>Jenis</th><th>Harga/Jam</th><th>Status</th><th width="180">Aksi</th></tr></thead>
            <tbody>
            @forelse($facilities as $facility)
                <tr>
                    <td>{{ $facility->nama_fasilitas }}</td>
                    <td>{{ $facility->jenis }}</td>
                    <td>Rp {{ number_format($facility->harga_per_jam, 0, ',', '.') }}</td>
                    <td>{!! $facility->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Nonaktif</span>' !!}</td>
                    <td>
                        <a href="{{ route('admin.facilities.edit', $facility) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.facilities.destroy', $facility) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus fasilitas ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Belum ada fasilitas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
