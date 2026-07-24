@extends('Admin.layout')

@section('title', 'Pengaturan Sistem')

@section('content')

<div class="card content-card">
    <div class="card-body p-4">

        <h5 class="section-title">
            Pengaturan Sistem
        </h5>

        <div class="section-subtitle mb-4">
            Kelola pengaturan global website GOR GAZA.
        </div>

        @if(session('success'))
            <div class="alert alert-success rounded-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- Booking --}}
                <div class="col-md-6">

                    <div class="border rounded-4 p-3 h-100">

                        <h6 class="fw-bold mb-3">
                            Pengaturan Booking
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">
                                Nominal DP
                            </label>

                            <input
                                type="number"
                                name="nominal_dp"
                                class="form-control"
                                value="{{ old('nominal_dp',$setting->nominal_dp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Jam Buka
                            </label>

                            <input
                                type="time"
                                name="jam_buka"
                                class="form-control"
                                value="{{ old('jam_buka',$setting->jam_buka) }}">
                        </div>

                        <div>
                            <label class="form-label">
                                Jam Tutup
                            </label>

                            <input
                                type="time"
                                name="jam_tutup"
                                class="form-control"
                                value="{{ old('jam_tutup',$setting->jam_tutup) }}">
                        </div>

                    </div>

                </div>

                {{-- Kontak --}}
                <div class="col-md-6">

                    <div class="border rounded-4 p-3 h-100">

                        <h6 class="fw-bold mb-3">
                            Kontak
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">
                                WhatsApp
                            </label>

                            <input
                                type="text"
                                name="whatsapp"
                                class="form-control"
                                value="{{ old('whatsapp',$setting->whatsapp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email',$setting->email) }}">
                        </div>

                        <div>
                            <label class="form-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                class="form-control"
                                rows="3">{{ old('alamat',$setting->alamat) }}</textarea>
                        </div>

                    </div>

                </div>

                {{-- Sosial Media --}}
                <div class="col-12">

                    <div class="border rounded-4 p-3">

                        <h6 class="fw-bold mb-3">
                            Sosial Media & Google Maps
                        </h6>

                        <div class="mb-3">
                            <label class="form-label">
                                Link Google Maps
                            </label>

                            <textarea
                                name="maps"
                                class="form-control"
                                rows="3">{{ old('maps',$setting->maps) }}</textarea>
                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <label class="form-label">
                                    Instagram
                                </label>

                                <input
                                    type="text"
                                    name="instagram"
                                    class="form-control"
                                    value="{{ old('instagram',$setting->instagram) }}">

                            </div>

                            <div class="col-md-6">

                                <label class="form-label">
                                    TikTok
                                </label>

                                <input
                                    type="text"
                                    name="tiktok"
                                    class="form-control"
                                    value="{{ old('tiktok',$setting->tiktok) }}">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mt-4">

                <button class="btn btn-gaza rounded-4">

                    <i class="fa-solid fa-floppy-disk me-2"></i>

                    Simpan Pengaturan

                </button>

            </div>

        </form>

    </div>
</div>

@endsection