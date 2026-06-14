@extends('Admin.layout')

@section('title', 'Edit Gambar Landing')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <h5 class="section-title">Edit Gambar Landing</h5>
        <div class="section-subtitle mb-4">Perbarui gambar yang tampil di landing page.</div>
        <form action="{{ route('admin.site-images.update', $siteImage) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('Admin.site_images._form')
        </form>
    </div>
</div>
@endsection
