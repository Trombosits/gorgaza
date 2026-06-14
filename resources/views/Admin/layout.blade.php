<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') - GOR GAZA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --gaza-dark: #0f172a;
            --gaza-muted: #64748b;
            --gaza-border: #e2e8f0;
            --gaza-bg: #f8fafc;
            --gaza-primary: #f59e0b;
            --gaza-primary-soft: #fef3c7;
            --gaza-success: #16a34a;
            --gaza-danger: #dc2626;
            --gaza-info: #2563eb;
        }
        * { font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif; }
        body { background: var(--gaza-bg); color: var(--gaza-dark); overflow-x: hidden; }
        .admin-shell { min-height: 100vh; padding-left: 272px; }
        .sidebar {
            min-height: 100vh;
            height: 100vh;
            width: 272px;
            background: linear-gradient(180deg, #111827 0%, #0f172a 55%, #020617 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            overflow-y: auto;
            box-shadow: 18px 0 40px rgba(15, 23, 42, .12);
        }
        .admin-shell > .row { min-height: 100vh; display: block; }
        .main-content {
            min-height: 100vh;
            width: 100%;
            max-width: 100%;
            flex: 0 0 100% !important;
            margin-left: 0;
        }
        .sidebar::-webkit-scrollbar { width: 7px; }
        .sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 999px; }
        .brand-box {
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 22px;
            padding: 16px;
        }
        .brand-logo {
            width: 44px; height: 44px; border-radius: 16px;
            display: inline-flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: #111827; font-weight: 900;
        }
        .admin-brand-logo-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            display: block;
            border-radius: 16px;
            filter: drop-shadow(0 10px 20px rgba(245, 158, 11, .22));
        }
        .sidebar-section { color: #94a3b8; font-size: 11px; letter-spacing: .12em; text-transform: uppercase; margin: 24px 10px 10px; }
        .sidebar a.nav-link-admin {
            color: #cbd5e1;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 6px;
            transition: .2s ease;
            font-weight: 600;
        }
        .sidebar a.nav-link-admin i { width: 20px; text-align: center; }
        .sidebar a.nav-link-admin:hover,
        .sidebar a.nav-link-admin.active {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: #111827;
            transform: translateX(3px);
        }
        .topbar {
            background: rgba(255,255,255,.82);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(226,232,240,.85);
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(15,23,42,.06);
        }
        .content-card,
        .card-stat {
            border: 1px solid rgba(226,232,240,.9);
            border-radius: 24px;
            box-shadow: 0 18px 45px rgba(15,23,42,.06);
            overflow: hidden;
        }
        .card-stat { position: relative; background: #fff; }
        .card-stat::after {
            content: '';
            position: absolute;
            right: -35px;
            top: -35px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: var(--stat-color, rgba(245,158,11,.12));
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--stat-color, rgba(245,158,11,.12));
            color: var(--stat-text, #b45309);
            font-size: 20px;
        }
        .stat-label { color: var(--gaza-muted); font-size: 13px; font-weight: 700; }
        .stat-value { font-size: 28px; font-weight: 800; margin: 6px 0 0; }
        .table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 1px solid var(--gaza-border);
            padding: 14px;
        }
        .table tbody td { padding: 14px; vertical-align: middle; }
        .badge-soft { border-radius: 999px; padding: 7px 10px; font-weight: 700; font-size: 12px; }
        .badge-booking { background: #fef3c7; color: #92400e; }
        .badge-confirmed { background: #dbeafe; color: #1d4ed8; }
        .badge-completed { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-out-of-time { background: #e5e7eb; color: #374151; }
        .btn-gaza { background: linear-gradient(135deg, #f59e0b, #fbbf24); border: 0; color: #111827; font-weight: 800; }
        .btn-gaza:hover { color: #111827; filter: brightness(.96); }
        .btn-soft { border: 1px solid var(--gaza-border); background: #fff; color: #334155; font-weight: 700; }
        .form-control, .form-select { border-radius: 14px; border-color: #dbe3ef; padding: 11px 14px; }
        .form-control:focus, .form-select:focus { border-color: #f59e0b; box-shadow: 0 0 0 .25rem rgba(245,158,11,.14); }
        .section-title { font-weight: 800; margin-bottom: 4px; }
        .section-subtitle { color: var(--gaza-muted); font-size: 14px; }
        .empty-state { padding: 52px 16px; text-align: center; color: var(--gaza-muted); }
        .empty-state i { font-size: 34px; color: #cbd5e1; margin-bottom: 12px; }

        /* Pagination admin dibuat khusus agar rapi dan tidak memakai tampilan bawaan Laravel. */
        .admin-pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 16px 18px;
            margin-top: 18px;
            border: 1px solid rgba(226, 232, 240, .9);
            border-radius: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #fffbeb 100%);
            box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
        }
        .admin-pagination-info {
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }
        .admin-pagination-info strong {
            color: #0f172a;
            font-weight: 900;
        }
        .admin-pagination-list {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .admin-page-link {
            min-width: 40px;
            height: 40px;
            padding: 0 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #334155;
            text-decoration: none;
            font-size: 14px;
            font-weight: 900;
            line-height: 1;
            transition: .2s ease;
        }
        .admin-page-link i {
            font-size: 13px;
            line-height: 1;
        }
        .admin-page-item:not(.disabled):not(.active) .admin-page-link:hover {
            color: #111827;
            border-color: #f59e0b;
            background: #fef3c7;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(245, 158, 11, .16);
        }
        .admin-page-item.active .admin-page-link {
            color: #111827;
            border-color: transparent;
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            box-shadow: 0 12px 26px rgba(245, 158, 11, .24);
        }
        .admin-page-item.disabled .admin-page-link {
            color: #cbd5e1;
            background: #f8fafc;
            cursor: not-allowed;
            box-shadow: none;
        }
        .admin-page-link.dots {
            min-width: 32px;
            border-color: transparent;
            background: transparent;
            color: #94a3b8;
        }
        .main-content nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
        }


        .badminton-racket-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.25em;
            height: 1.25em;
            font-size: 1.05em;
            line-height: 1;
        }
        .nav-racket-icon { margin-right: 0; }

        @media (max-width: 767.98px) {
            .admin-shell { padding-left: 0; }
            .admin-shell > .row { display: flex; }
            .sidebar { min-height: auto; height: auto; width: 100%; position: relative; overflow-y: visible; }
            .sidebar a.nav-link-admin { display: inline-flex; margin-right: 6px; }
            .main-content { padding: 18px !important; }
            .admin-pagination-wrap { align-items: flex-start; flex-direction: column; }
            .admin-pagination-list { width: 100%; justify-content: flex-start; flex-wrap: wrap; }
        }
    </style>
</head>
<body>
<div class="container-fluid admin-shell">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <div class="brand-box mb-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ asset('images/logo-gorgaza.png') }}" alt="GOR GAZA" class="admin-brand-logo-img">
                    <div>
                        <div class="text-warning fw-black fw-bold">GOR GAZA</div>
                        <small class="text-light opacity-75">Panel Admin</small>
                    </div>
                </div>
            </div>

            <div class="sidebar-section">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link-admin {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Beranda
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-link-admin {{ request()->is('admin/reservations*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> Pemesanan
            </a>
            <a href="{{ route('admin.facilities.index') }}" class="nav-link-admin {{ request()->is('admin/facilities*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Fasilitas
            </a>
            <a href="{{ route('admin.cafe-menus.index') }}" class="nav-link-admin {{ request()->is('admin/cafe-menus*') ? 'active' : '' }}">
                <i class="fa-solid fa-mug-saucer"></i> Menu Kafe
            </a>
            <a href="{{ route('admin.site-images.index') }}" class="nav-link-admin {{ request()->is('admin/site-images*') ? 'active' : '' }}">
                <i class="fa-solid fa-images"></i> Gambar Landing
            </a>
            <a href="{{ route('admin.feedbacks.index') }}" class="nav-link-admin {{ request()->is('admin/feedbacks*') ? 'active' : '' }}">
                <i class="fa-regular fa-comment-dots"></i> Kritik & Saran
            </a>
            <a href="{{ route('admin.reports.finance') }}" class="nav-link-admin {{ request()->is('admin/reports/finance*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Laporan Keuangan
            </a>

            <div class="sidebar-section">Akses</div>
            <a href="/" target="_blank" class="nav-link-admin">
                <i class="fa-solid fa-globe"></i> Lihat Website
            </a>

            <form action="/logout" method="POST" class="mt-3">
                @csrf
                <button class="btn btn-outline-warning w-100 rounded-4 fw-bold" type="submit">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
                </button>
            </form>
        </aside>

        <main class="col-md-9 col-lg-10 p-4 main-content">
            <div class="topbar p-4 mb-4 d-flex flex-wrap gap-3 justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">@yield('title')</h2>
                    <div class="section-subtitle">Kelola data pemesanan, fasilitas, dan laporan GOR GAZA.</div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-bold">{{ session('auth_user.name') ?? session('auth_user.nama') ?? 'Admin' }}</div>
                        <small class="text-muted">Admin</small>
                    </div>
                    <div class="stat-icon" style="--stat-color:#fef3c7;--stat-text:#92400e;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 rounded-4 shadow-sm"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-4 shadow-sm"><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-4 shadow-sm">
                    <strong>Periksa lagi input berikut:</strong>
                    <ul class="mb-0 mt-2">
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
