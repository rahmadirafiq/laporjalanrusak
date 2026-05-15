<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin – LaporJalanRusak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <style>
    :root { --primary:#1A56A0; --primary-dark:#0F3A72; --border:#E2EAF4; --text-muted:#64748B; }
    body { font-family:'Plus Jakarta Sans',sans-serif; background: linear-gradient(135deg,var(--primary-dark),var(--primary)); min-height:100vh; display:flex; align-items:center; justify-content:center; }
    .login-card { background:#fff; border-radius:20px; padding:44px 40px; width:100%; max-width:420px; box-shadow:0 20px 60px rgba(0,0,0,.2); }
    .login-icon { width:60px; height:60px; border-radius:16px; background:var(--primary); display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.5rem; margin:0 auto 20px; }
    .login-card h3 { font-weight:800; font-size:1.4rem; text-align:center; margin-bottom:4px; }
    .login-card .sub { text-align:center; color:var(--text-muted); font-size:.85rem; margin-bottom:28px; }
    .form-label { font-weight:600; font-size:.83rem; margin-bottom:5px; }
    .form-control { border:1.5px solid var(--border); border-radius:10px; padding:11px 14px 11px 42px; font-size:.88rem; }
    .form-control:focus { border-color:var(--primary); box-shadow:0 0 0 3px rgba(26,86,160,.1); outline:none; }
    .input-wrap { position:relative; }
    .input-wrap .icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:var(--text-muted); }
    .btn-login { background:var(--primary); color:#fff; font-weight:700; padding:13px; border-radius:10px; border:none; width:100%; font-size:.93rem; transition:background .2s; }
    .btn-login:hover { background:var(--primary-dark); }
    .admin-badge { background:#EFF6FF; border:1px solid #BFDBFE; border-radius:10px; padding:10px 14px; font-size:.82rem; color:#1E40AF; margin-bottom:20px; text-align:center; }
  </style>
</head>
<body>
<div class="login-card">
  <div class="login-icon"><i class="bi bi-shield-lock-fill"></i></div>
  <h3>Panel Admin</h3>
  <p class="sub">LaporJalanRusak – Dinas PU Bukittinggi</p>

  @if($errors->any())
  <div class="alert alert-danger rounded-3 mb-3" style="font-size:.83rem;">
    @foreach($errors->all() as $e) {{ $e }} @endforeach
  </div>
  @endif

  <div class="admin-badge">
    <i class="bi bi-info-circle me-1"></i>Akses khusus petugas & admin Dinas PU
  </div>

  <form action="{{ route('admin.login') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">Email Admin</label>
      <div class="input-wrap">
        <i class="bi bi-envelope icon"></i>
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="admin@laporjalanrusak.id" required/>
      </div>
    </div>
    <div class="mb-4">
      <label class="form-label">Password</label>
      <div class="input-wrap">
        <i class="bi bi-lock icon"></i>
        <input type="password" class="form-control" name="password" placeholder="Password admin" required/>
      </div>
    </div>
    <button type="submit" class="btn-login">
      <i class="bi bi-shield-check me-2"></i>Masuk sebagai Admin
    </button>
  </form>

  <p class="text-center mt-3" style="font-size:.8rem;color:var(--text-muted);">
    <a href="{{ route('landing') }}" style="color:var(--primary);text-decoration:none;">
      <i class="bi bi-arrow-left me-1"></i>Kembali ke halaman utama
    </a>
  </p>
</div>
</body>
</html>