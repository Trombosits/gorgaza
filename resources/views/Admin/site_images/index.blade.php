@extends('Admin.layout')

@section('title', 'Kelola Gambar Landing')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Gambar Landing Page</h5>
                <div class="section-subtitle">Kelola gambar hero slider dan galeri fasilitas pada landing page.</div>
            </div>
            <a href="{{ route('admin.site-images.create') }}" class="btn btn-gaza rounded-4"><i class="fa-solid fa-plus me-2"></i>Tambah Gambar</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Kategori</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($images as $image)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset($image->path_gambar) }}" alt="{{ $image->alt_text ?: $image->judul }}" style="width:92px;height:62px;object-fit:cover;border-radius:16px;">
                                    <div>
                                        <div class="fw-bold">{{ $image->judul }}</div>
                                        <small class="text-muted">{{ $image->alt_text ?: 'Tanpa alt text' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $image->kategori }}</td>
                            <td>{{ $image->urutan }}</td>
                            <td>
                                @if($image->is_active)
                                    <span class="badge-soft badge-completed">Tampil</span>
                                @else
                                    <span class="badge-soft badge-cancelled">Disembunyikan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.site-images.edit', $image) }}" class="btn btn-sm btn-soft rounded-3"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.site-images.destroy', $image) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-3"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"><div class="empty-state"><i class="fa-solid fa-images"></i><div>Belum ada gambar landing.</div></div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
