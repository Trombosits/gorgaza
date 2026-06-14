@extends('Admin.layout')

@section('title', 'Kritik & Saran')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
            <div>
                <h5 class="section-title">Kritik & Saran Pelanggan</h5>
                <div class="section-subtitle">Pesan ini bersifat privat dan hanya terlihat di panel admin.</div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th>Pesan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($feedbacks as $feedback)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $feedback->nama }}</div>
                                <small class="text-muted">{{ $feedback->email }}</small>
                            </td>
                            <td style="max-width:420px;">
                                {{ \Illuminate\Support\Str::limit($feedback->pesan, 110) }}
                            </td>
                            <td>
                                @if($feedback->is_read)
                                    <span class="badge-soft badge-completed">Sudah Dibaca</span>
                                @else
                                    <span class="badge-soft badge-booking">Baru</span>
                                @endif
                            </td>
                            <td>{{ $feedback->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.feedbacks.show', $feedback) }}" class="btn btn-sm btn-soft rounded-3"><i class="fa-solid fa-eye"></i></a>
                                <form action="{{ route('admin.feedbacks.destroy', $feedback) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kritik dan saran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger rounded-3"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"><div class="empty-state"><i class="fa-regular fa-comment-dots"></i><div>Belum ada kritik dan saran.</div></div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $feedbacks->onEachSide(1)->links('Admin.components.pagination') }}
        </div>
    </div>
</div>
@endsection
