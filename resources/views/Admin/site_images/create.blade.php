@extends('Admin.layout')

@section('title', 'Tambah Gambar Landing')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <h5 class="section-title">Tambah Gambar Landing</h5>
        <div class="section-subtitle mb-4">Gambar aktif akan tampil sesuai kategori pada landing page.</div>
        <form action="{{ route('admin.site-images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('Admin.site_images._form')
        </form>
    </div>
</div>
@endsection
