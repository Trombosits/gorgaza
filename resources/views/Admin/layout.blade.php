<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - GOR GAZA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background:#f5f6fa; }
        .sidebar { min-height:100vh; background:#111827; }
        .sidebar a { color:#d1d5db; text-decoration:none; display:block; padding:12px 18px; border-radius:10px; margin-bottom:6px; }
        .sidebar a:hover, .sidebar a.active { background:#f59e0b; color:#111827; }
        .card-stat { border:0; border-radius:16px; box-shadow:0 8px 24px rgba(15,23,42,.08); }
        .content-card { border:0; border-radius:16px; box-shadow:0 8px 24px rgba(15,23,42,.08); }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <h4 class="text-warning fw-bold mb-4">GOR GAZA</h4>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge me-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="{{ request()->is('admin/reservations*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check me-2"></i> Booking
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="{{ request()->is('admin/facilities*') ? 'active' : '' }}">
                <i class="fa-solid fa-dumbbell me-2"></i> Fasilitas
            </a>
            <a href="/" target="_blank"><i class="fa-solid fa-globe me-2"></i> Lihat Website</a>
            <form action="/logout" method="POST" class="mt-4">
                @csrf
                <button class="btn btn-outline-warning w-100" type="submit">Logout</button>
            </form>
        </aside>

        <main class="col-md-9 col-lg-10 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">@yield('title')</h2>
                    <small class="text-muted">Login sebagai {{ session('auth_user.name') }}</small>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
