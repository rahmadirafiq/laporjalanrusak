<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Masuk – LaporJalanRusak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital@0;1&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <style>
    :root { --primary:#1A56A0;--primary-dark:#0F3A72;--accent:#F97316;--light-bg:#F4F8FF;--text-dark:#0F172A;--text-muted:#64748B;--border:#E2EAF4; }
    * { box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif;color:var(--text-dark);background:var(--light-bg);min-height:100vh; }
    .auth-wrapper { min-height:100vh;display:flex; }
    .auth-left { flex:0 0 45%;background:linear-gradient(160deg,var(--primary-dark) 0%,var(--primary) 60%,#2563EB 100%);position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:center;padding:60px 56px; }
    .auth-left::before { content:'';position:absolute;bottom:-80px;right:-80px;width:400px;height:400px;border-radius:50%;background:rgba(255,255,255,.06); }
    .auth-brand { display:flex;align-items:center;gap:12px;margin-bottom:52px; }
    .auth-brand .icon { width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem; }
    .auth-brand span { font-weight:800;font-size:1.2rem;color:#fff; }
    .auth-left h2 { font-family:'Lora',serif;color:#fff;font-size:2rem;font-weight:700;margin-bottom:14px; }
    .auth-left p { color:rgba(255,255,255,.75);font-size:.95rem;line-height:1.7;margin-bottom:40px; }
    .info-item { display:flex;align-items:center;gap:12px;margin-bottom:18px; }
    .info-icon { width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,.15);display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0; }
    .info-item span { color:rgba(255,255,255,.85);font-size:.88rem; }
    .auth-right { flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px; }
    .auth-card { background:#fff;border-radius:20px;padding:44px 40px;width:100%;max-width:440px;box-shadow:0 8px 40px rgba(0,0,0,.08); }
    .auth-card h3 { font-weight:800;font-size:1.5rem;margin-bottom:6px; }
    .auth-card .subtitle { color:var(--text-muted);font-size:.9rem;margin-bottom:28px; }
    .form-label { font-weight:600;font-size:.85rem;margin-bottom:6px; }
    .form-control { border:1.5px solid var(--border);border-radius:10px;padding:11px 14px;font-size:.9rem;transition:border-color .2s,box-shadow .2s; }
    .form-control:focus { border-color:var(--primary);box-shadow:0 0 0 3px rgba(26,86,160,.12);outline:none; }
    .input-icon-wrap { position:relative; }
    .input-icon-wrap .form-control { padding-left:42px; }
    .input-icon-wrap .icon { position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:1rem; }
    .input-icon-wrap .toggle-pw { position:absolute;right:13px;top:50%;transform:translateY(-50%);color:var(--text-muted);cursor:pointer;font-size:1rem; }
    .btn-primary-custom { background:var(--primary);color:#fff;font-weight:700;padding:13px;border-radius:10px;border:none;width:100%;font-size:.95rem;transition:background .2s,transform .15s; }
    .btn-primary-custom:hover { background:var(--primary-dark);transform:translateY(-1px); }
    .divider { display:flex;align-items:center;gap:12px;margin:20px 0; }
    .divider::before,.divider::after { content:'';flex:1;height:1px;background:var(--border); }
    .divider span { color:var(--text-muted);font-size:.82rem; }
    .link-primary { color:var(--primary);font-weight:600;text-decoration:none; }
    .link-primary:hover { text-decoration:underline; }
    .alert-info-custom { background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:12px 14px;font-size:.85rem;color:#1E40AF;margin-bottom:20px; }
    @media(max-width:767px) { .auth-left{display:none;} .auth-card{padding:32px 24px;} }
  </style>
</head>
<body>
<div class="auth-wrapper">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="icon"><i class="bi bi-geo-alt-fill"></i></div>
      <span>LaporJalanRusak</span>
    </div>
    <h2>Selamat Datang Kembali!</h2>
    <p>Masuk untuk memantau laporan Anda dan berkontribusi bagi infrastruktur Kota Bukittinggi yang lebih baik.</p>
    <div class="info-item">
      <div class="info-icon"><i class="bi bi-camera-fill"></i></div>
      <span>Laporkan kerusakan jalan dengan foto dan lokasi GPS</span>
    </div>
    <div class="info-item">
      <div class="info-icon"><i class="bi bi-bar-chart-fill"></i></div>
      <span>Pantau status laporan Anda secara real-time</span>
    </div>
    <div class="info-item">
      <div class="info-icon"><i class="bi bi-bell-fill"></i></div>
      <span>Terima notifikasi otomatis setiap pembaruan</span>
    </div>
  </div>
  <div class="auth-right">
    <div class="auth-card">
      <h3>Masuk ke Akun</h3>
      <p class="subtitle">Belum punya akun? <a href="{{ route('register') }}" class="link-primary">Daftar di sini</a></p>

      @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3" style="font-size:.85rem;">
          @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
      @endif

      <div class="alert-info-custom">
        <i class="bi bi-info-circle-fill me-2"></i>
        Gunakan email dan password yang Anda daftarkan sebelumnya.
      </div>

      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Alamat Email</label>
          <div class="input-icon-wrap">
            <i class="bi bi-envelope icon"></i>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required/>
          </div>
        </div>
        <div class="mb-2">
          <label class="form-label">Password</label>
          <div class="input-icon-wrap">
            <i class="bi bi-lock icon"></i>
            <input type="password" class="form-control" name="password" id="pw" placeholder="Masukkan password" required/>
            <i class="bi bi-eye toggle-pw" onclick="togglePw()"></i>
          </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember"/>
            <label class="form-check-label" for="remember" style="font-size:.85rem;">Ingat saya</label>
          </div>
        </div>
        <button type="submit" class="btn-primary-custom">
          <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>
      </form>

      <div class="divider"><span>atau</span></div>
      <p class="text-center" style="font-size:.88rem;color:var(--text-muted);">
        Ingin melapor tanpa akun?
        <a href="{{ route('laporan.form') }}" class="link-primary">Lapor sebagai tamu</a>
      </p>
      <p class="text-center mt-3" style="font-size:.82rem;color:var(--text-muted);">
        <a href="{{ route('landing') }}" class="link-primary"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
      </p>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePw() {
    const pw = document.getElementById('pw');
    const icon = document.querySelector('.toggle-pw');
    if (pw.type === 'password') { pw.type = 'text'; icon.classList.replace('bi-eye','bi-eye-slash'); }
    else { pw.type = 'password'; icon.classList.replace('bi-eye-slash','bi-eye'); }
  }
</script>
</body>
</html>