@extends('Admin.layout')

@section('title', 'Detail Kritik & Saran')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-start mb-4">
            <div>
                <h5 class="section-title">Pesan dari {{ $feedback->nama }}</h5>
                <div class="section-subtitle">{{ $feedback->email }} · {{ $feedback->created_at->format('d M Y, H:i') }} WIB</div>
            </div>
            <a href="{{ route('admin.feedbacks.index') }}" class="btn btn-soft rounded-4"><i class="fa-solid fa-arrow-left me-2"></i>Kembali</a>
        </div>

        <div class="p-4 rounded-4" style="background:#f8fafc;border:1px solid #e2e8f0;line-height:1.8;white-space:pre-line;">{{ $feedback->pesan }}</div>

        <form action="{{ route('admin.feedbacks.destroy', $feedback) }}" method="POST" class="mt-4" onsubmit="return confirm('Hapus kritik dan saran ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger rounded-4"><i class="fa-solid fa-trash me-2"></i>Hapus Pesan</button>
        </form>
    </div>
</div>
@endsection
