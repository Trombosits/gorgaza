@extends('Admin.layout')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="card content-card">
    <div class="card-body p-4">
        <h5 class="section-title">Form Tambah Fasilitas</h5>
        <div class="section-subtitle mb-4">Masukkan data fasilitas baru yang tersedia untuk booking.</div>
        <form action="{{ route('admin.facilities.store') }}" method="POST">
            @csrf
            @include('Admin.facilities._form')
        </form>
    </div>
</div>
@endsection
