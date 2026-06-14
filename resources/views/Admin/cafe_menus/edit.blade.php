@extends('Admin.layout')

@section('title', 'Edit Menu Kafe')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <h5 class="section-title">Edit Menu Kafe</h5>
        <div class="section-subtitle mb-4">Perbarui data menu kafe yang tampil di landing page.</div>
        <form action="{{ route('admin.cafe-menus.update', $cafeMenu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('Admin.cafe_menus._form')
        </form>
    </div>
</div>
@endsection
