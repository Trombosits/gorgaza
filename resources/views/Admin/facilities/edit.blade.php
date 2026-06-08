@extends('Admin.layout')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="card content-card"><div class="card-body">
    <form action="{{ route('admin.facilities.update', $facility) }}" method="POST">
        @csrf @method('PUT')
        @include('Admin.facilities._form')
    </form>
</div></div>
@endsection
