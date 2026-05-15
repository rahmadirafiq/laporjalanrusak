<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Admin') – LaporJalanRusak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <style>
    :root {
      --primary:#1A56A0; --primary-dark:#0F3A72;
      --accent:#F97316;  --sidebar-w:260px;
      --text-dark:#0F172A; --text-muted:#64748B; --border:#E2EAF4; --light-bg:#F4F8FF;
    }
    * { box-sizing: border-box; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--light-bg); color: var(--text-dark); }

    /* Sidebar */
    .sidebar { position: fixed; top: 0; left: 0; width: var(--sidebar-w); height: 100vh; background: var(--primary-dark); overflow-y: auto; z-index: 1000; display: flex; flex-direction: column; }
    .sidebar-brand { padding: 24px 20px 16px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(255,255,255,.1); }
    .sidebar-brand .icon { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; color: #fff; font-size: .95rem; }
    .sidebar-brand span { font-weight: 800; color: #fff; font-size: 1rem; }
    .sidebar-brand small { display: block; color: rgba(255,255,255,.5); font-size: .7rem; font-weight: 400; }
    .sidebar-nav { padding: 16px 12px; flex: 1; }
    .nav-label { font-size: .68rem; font-weight: 700; color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing: .08em; padding: 12px 8px 6px; }
    .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 12px; color: rgba(255,255,255,.7); text-decoration: none; border-radius: 10px; font-size: .88rem; font-weight: 500; transition: all .2s; margin-bottom: 2px; }
    .sidebar-nav a:hover { background: rgba(255,255,255,.1); color: #fff; }
    .sidebar-nav a.active { background: rgba(255,255,255,.15); color: #fff; font-weight: 700; }
    .sidebar-nav a i { font-size: 1rem; width: 20px; }
    .sidebar-footer { padding: 16px 12px; border-top: 1px solid rgba(255,255,255,.1); }
    .admin-info { display: flex; align-items: center; gap: 10px; padding: 10px 12px; }
    .admin-avatar { width: 36px; height: 36px; border-radius: 50%; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: .82rem; flex-shrink: 0; }
    .admin-info .name { color: #fff; font-size: .85rem; font-weight: 600; }
    .admin-info .role { color: rgba(255,255,255,.5); font-size: .72rem; }

    /* Main */
    .main-wrapper { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
    .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; }
    .topbar h6 { font-weight: 700; margin: 0; font-size: .95rem; }
    .page-body { padding: 28px; flex: 1; }

    /* Cards */
    .stat-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 22px; }
    .stat-card .num { font-size: 2rem; font-weight: 800; }
    .stat-card .label { font-size: .82rem; color: var(--text-muted); margin-top: 2px; }
    .stat-card .icon-wrap { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }

    /* Table */
    .data-table { background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
    .data-table .table { margin: 0; font-size: .85rem; }
    .data-table .table th { background: var(--light-bg); font-weight: 700; font-size: .78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; border-bottom: 1px solid var(--border); padding: 12px 16px; }
    .data-table .table td { padding: 12px 16px; vertical-align: middle; border-bottom: 1px solid var(--border); }
    .data-table .table tr:last-child td { border-bottom: none; }

    /* Badge status */
    .badge-menunggu    { background:#FEF3C7;color:#92400E; }
    .badge-diverifikasi{ background:#DBEAFE;color:#1E40AF; }
    .badge-proses      { background:#FEE2E2;color:#991B1B; }
    .badge-selesai     { background:#D1FAE5;color:#065F46; }
    .badge-ditolak     { background:#F1F5F9;color:#475569; }
    .status-badge { display:inline-block;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:700; }

    /* Filter bar */
    .filter-bar { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 18px 20px; margin-bottom: 20px; }
    .filter-bar .form-control, .filter-bar .form-select { border: 1.5px solid var(--border); border-radius: 10px; font-size: .85rem; padding: 8px 12px; }

    @media(max-width:991px) {
      .sidebar { transform: translateX(-100%); }
      .main-wrapper { margin-left: 0; }
    }
  </style>
  @stack('styles')
</head>
<body>

<div class="sidebar">
  <div class="sidebar-brand">
    <div class="icon"><i class="bi bi-geo-alt-fill"></i></div>
    <div>
      <span>LaporJalanRusak</span>
      <small>Panel Admin</small>
    </div>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-label">Utama</div>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <div class="nav-label">Manajemen</div>
    <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
      <i class="bi bi-file-text"></i> Kelola Laporan
    </a>
    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
      <i class="bi bi-people"></i> Kelola Pengguna
    </a>
    <div class="nav-label">Export</div>
    <a href="{{ route('admin.laporan.export') }}">
      <i class="bi bi-download"></i> Export CSV
    </a>
    <div class="nav-label">Akses</div>
    <a href="{{ url('/') }}" target="_blank">
      <i class="bi bi-globe"></i> Lihat Website
    </a>
  </nav>
  <div class="sidebar-footer">
    <div class="admin-info">
      <div class="admin-avatar">{{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 2)) }}</div>
      <div>
        <div class="name">{{ Auth::guard('admin')->user()->name }}</div>
        <div class="role">{{ ucfirst(Auth::guard('admin')->user()->role) }}</div>
      </div>
    </div>
    <form action="{{ route('admin.logout') }}" method="POST" class="mt-1">
      @csrf
      <button type="submit" style="width:100%;background:rgba(255,255,255,.08);border:none;border-radius:10px;padding:9px;color:rgba(255,255,255,.7);font-size:.83rem;font-weight:600;cursor:pointer;">
        <i class="bi bi-box-arrow-right me-2"></i>Keluar
      </button>
    </form>
  </div>
</div>

<div class="main-wrapper">
  <div class="topbar">
    <h6>@yield('page-title', 'Dashboard')</h6>
    <div style="font-size:.82rem;color:var(--text-muted);">
      <i class="bi bi-clock me-1"></i><span id="jam-wib">...</span>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show m-0 rounded-0" style="font-size:.85rem;">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  @if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show m-0 rounded-0" style="font-size:.85rem;">
    @foreach($errors->all() as $e) <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $e }}<br> @endforeach
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="page-body">
    @yield('content')
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Jam WIB realtime
function updateJamWIB() {
  const now = new Date();
  const opts = {
    timeZone: 'Asia/Jakarta',
    day: '2-digit', month: 'short', year: 'numeric',
    hour: '2-digit', minute: '2-digit', hour12: false
  };
  const parts = new Intl.DateTimeFormat('id-ID', opts).formatToParts(now);
  const get = type => parts.find(p => p.type === type)?.value ?? '';
  document.getElementById('jam-wib').textContent =
    `${get('day')} ${get('month')} ${get('year')}, ${get('hour')}:${get('minute')} WIB`;
}
updateJamWIB();
setInterval(updateJamWIB, 60000);
</script>
@stack('scripts')
</body>
</html>