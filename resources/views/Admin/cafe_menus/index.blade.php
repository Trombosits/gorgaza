@extends('Admin.layout')

@section('title', 'Kelola Menu Kafe')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Data Menu Kafe</h5>
                <div class="section-subtitle">Kelola nama menu, kategori, harga, dan status tampil di landing page.</div>
            </div>
            <a href="{{ route('admin.cafe-menus.create') }}" class="btn btn-gaza rounded-4"><i class="fa-solid fa-plus me-2"></i>Tambah Menu</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($menu->gambar)
                                        <img src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama_menu }}" style="width:56px;height:56px;object-fit:cover;border-radius:14px;">
                                    @else
                                        <div class="stat-icon" style="--stat-color:#fef3c7;--stat-text:#92400e;"><i class="fa-solid fa-utensils"></i></div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $menu->nama_menu }}</div>
                                        <small class="text-muted">{{ $menu->deskripsi ?: 'Tanpa deskripsi' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $menu->kategori }}</td>
                            <td class="fw-bold">{{ is_null($menu->harga) ? 'TBD' : 'Rp ' . number_format($menu->harga, 0, ',', '.') }}</td>
                            <td>{{ $menu->urutan }}</td>
                            <td>
                                @if($menu->is_active)
                                    <span class="badge-soft badge-completed">Tampil</span>
                                @else
                                    <span class="badge-soft badge-cancelled">Disembunyikan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.cafe-menus.edit', $menu) }}" class="btn btn-sm btn-soft rounded-3"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.cafe-menus.destroy', $menu) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-3"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6"><div class="empty-state"><i class="fa-solid fa-mug-saucer"></i><div>Belum ada menu kafe.</div></div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
