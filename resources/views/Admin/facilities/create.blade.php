@extends('Admin.layout')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="card content-card"><div class="card-body">
    <form action="{{ route('admin.facilities.store') }}" method="POST">
        @csrf
        @include('Admin.facilities._form')
    </form>
</div></div>
@endsection
