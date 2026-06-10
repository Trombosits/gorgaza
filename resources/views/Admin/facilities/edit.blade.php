@extends('Admin.layout')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <h5 class="section-title">Form Edit Fasilitas</h5>
        <div class="section-subtitle mb-4">Perbarui data fasilitas yang sudah terdaftar.</div>
        <form action="{{ route('admin.facilities.update', $facility) }}" method="POST">
            @csrf @method('PUT')
            @include('Admin.facilities._form')
        </form>
    </div>
</div>
@endsection
