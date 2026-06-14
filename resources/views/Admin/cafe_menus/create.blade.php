@extends('Admin.layout')

@section('title', 'Tambah Menu Kafe')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <h5 class="section-title">Tambah Menu Kafe</h5>
        <div class="section-subtitle mb-4">Menu aktif akan tampil di bagian Menu Kafe pada landing page.</div>
        <form action="{{ route('admin.cafe-menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('Admin.cafe_menus._form')
        </form>
    </div>
</div>
@endsection
