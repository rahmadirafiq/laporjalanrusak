<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'LaporJalanRusak')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital@0;1&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <style>
    :root {
      --primary:#1A56A0; --primary-dark:#0F3A72;
      --accent:#F97316;  --light-bg:#F4F8FF;
      --text-dark:#0F172A; --text-muted:#64748B; --border:#E2EAF4;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-dark); background: var(--light-bg); }
    .navbar { background: #fff; border-bottom: 1px solid var(--border); }
    .navbar-brand { display: flex; align-items: center; gap: 10px; font-weight: 800; color: var(--primary) !important; }
    .brand-icon { width: 36px; height: 36px; border-radius: 10px; background: var(--primary); display: flex; align-items: center; justify-content: center; color: #fff; font-size: .95rem; }
    .btn-lapor { background: var(--accent); color: #fff !important; border-radius: 8px; padding: 7px 16px; font-weight: 700; font-size: .85rem; }
    .btn-lapor:hover { background: #e06010; }
    .avatar-nav { width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .85rem; cursor: pointer; }
    .badge-menunggu    { background: #FEF3C7; color: #92400E; }
    .badge-verifikasi  { background: #DBEAFE; color: #1E40AF; }
    .badge-proses      { background: #FEE2E2; color: #991B1B; }
    .badge-selesai     { background: #D1FAE5; color: #065F46; }
    .badge-ditolak     { background: #F1F5F9; color: #475569; }
    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: .78rem; font-weight: 700; }
  </style>
  @stack('styles')
</head>
<body>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show m-0 rounded-0" role="alert" style="font-size:.88rem;">
  <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show m-0 rounded-0" role="alert" style="font-size:.88rem;">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>
  @foreach($errors->all() as $e) {{ $e }} @endforeach
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landing') }}">
      <div class="brand-icon"><i class="bi bi-geo-alt-fill"></i></div>
      LaporJalanRusak
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav ms-auto align-items-center gap-1">
        <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}">Beranda</a></li>
        @auth
          <li class="nav-item"><a class="nav-link" href="{{ route('laporan.riwayat') }}">Laporan Saya</a></li>
        @endauth
        <li class="nav-item ms-2">
          <a class="nav-link btn-lapor d-flex align-items-center" href="{{ route('laporan.form') }}">
            <i class="bi bi-plus-circle me-1"></i>Buat Laporan
          </a>
        </li>
        @auth
          <li class="nav-item ms-2">
            <div class="dropdown">
              <div class="avatar-nav" data-bs-toggle="dropdown">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
              </div>
              <ul class="dropdown-menu dropdown-menu-end" style="font-size:.85rem;border-radius:12px;">
                <li><span class="dropdown-item-text fw-600" style="font-size:.82rem;color:var(--text-muted);">{{ Auth::user()->name }}</span></li>
                <li><hr class="dropdown-divider"/></li>
                <li><a class="dropdown-item" href="{{ route('profil') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                <li><a class="dropdown-item" href="{{ route('laporan.riwayat') }}"><i class="bi bi-clock-history me-2"></i>Riwayat</a></li>
                <li><hr class="dropdown-divider"/></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                      <i class="bi bi-box-arrow-right me-2"></i>Keluar
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
        @endauth
        @guest
        <!-- Link ke Admin Panel (hanya tampil jika belum login) -->
        <li class="nav-item">
          <a class="nav-link" href="{{ url('/admin/login') }}" style="font-size:.78rem;color:var(--text-muted);" title="Admin Panel">
            <i class="bi bi-shield-lock"></i>
          </a>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>