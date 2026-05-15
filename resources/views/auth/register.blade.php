<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar – LaporJalanRusak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital@0;1&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <style>
    :root { --primary:#1A56A0;--primary-dark:#0F3A72;--accent:#F97316;--light-bg:#F4F8FF;--text-dark:#0F172A;--text-muted:#64748B;--border:#E2EAF4; }
    * { box-sizing:border-box; }
    body { font-family:'Plus Jakarta Sans',sans-serif;color:var(--text-dark);background:var(--light-bg);min-height:100vh; }
    .auth-wrapper { min-height:100vh;display:flex; }
    .auth-left { flex:0 0 42%;background:linear-gradient(160deg,var(--primary-dark) 0%,var(--primary) 60%,#2563EB 100%);position:relative;overflow:hidden;display:flex;flex-direction:column;justify-content:center;padding:60px 50px; }
    .auth-brand { display:flex;align-items:center;gap:12px;margin-bottom:44px; }
    .auth-brand .icon { width:44px;height:44px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem; }
    .auth-brand span { font-weight:800;font-size:1.2rem;color:#fff; }
    .auth-left h2 { font-family:'Lora',serif;color:#fff;font-size:1.9rem;font-weight:700;margin-bottom:12px; }
    .auth-left p { color:rgba(255,255,255,.75);font-size:.9rem;line-height:1.7;margin-bottom:32px; }
    .step-list { list-style:none;padding:0;margin:0; }
    .step-list li { display:flex;align-items:flex-start;gap:14px;margin-bottom:20px;color:rgba(255,255,255,.85);font-size:.88rem; }
    .step-num { width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;color:#fff;flex-shrink:0; }
    .auth-right { flex:1;display:flex;align-items:center;justify-content:center;padding:40px 24px; }
    .auth-card { background:#fff;border-radius:20px;padding:40px 38px;width:100%;max-width:480px;box-shadow:0 8px 40px rgba(0,0,0,.08); }
    .auth-card h3 { font-weight:800;font-size:1.45rem;margin-bottom:5px; }
    .auth-card .subtitle { color:var(--text-muted);font-size:.88rem;margin-bottom:26px; }
    .form-label { font-weight:600;font-size:.83rem;margin-bottom:5px; }
    .form-control,.form-select { border:1.5px solid var(--border);border-radius:10px;padding:11px 14px;font-size:.88rem;transition:border-color .2s,box-shadow .2s; }
    .form-control:focus,.form-select:focus { border-color:var(--primary);box-shadow:0 0 0 3px rgba(26,86,160,.1);outline:none; }
    .input-icon-wrap { position:relative; }
    .input-icon-wrap .form-control,.input-icon-wrap .form-select { padding-left:42px; }
    .input-icon-wrap .icon { position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:.95rem; }
    .input-icon-wrap .toggle-pw { position:absolute;right:13px;top:50%;transform:translateY(-50%);color:var(--text-muted);cursor:pointer; }
    .btn-primary-custom { background:var(--primary);color:#fff;font-weight:700;padding:13px;border-radius:10px;border:none;width:100%;font-size:.93rem;transition:background .2s,transform .15s; }
    .btn-primary-custom:hover { background:var(--primary-dark);transform:translateY(-1px); }
    .link-primary { color:var(--primary);font-weight:600;text-decoration:none; }
    .pw-strength { height:4px;border-radius:4px;background:var(--border);margin-top:6px;overflow:hidden; }
    .pw-strength-bar { height:100%;border-radius:4px;width:0%;transition:width .3s,background .3s; }
    .strength-text { font-size:.75rem;margin-top:4px; }
    @media(max-width:767px) { .auth-left{display:none;} .auth-card{padding:28px 20px;} }
  </style>
</head>
<body>
<div class="auth-wrapper">
  <div class="auth-left">
    <div class="auth-brand">
      <div class="icon"><i class="bi bi-geo-alt-fill"></i></div>
      <span>LaporJalanRusak</span>
    </div>
    <h2>Bergabung & Berkontribusi</h2>
    <p>Daftarkan diri Anda dan mulai berkontribusi untuk infrastruktur jalan Kota Bukittinggi yang lebih baik.</p>
    <ul class="step-list">
      <li><div class="step-num">1</div><span>Isi formulir pendaftaran dengan data diri yang valid</span></li>
      <li><div class="step-num">2</div><span>Verifikasi akun melalui email yang Anda daftarkan</span></li>
      <li><div class="step-num">3</div><span>Mulai buat laporan kerusakan jalan di sekitar Anda</span></li>
      <li><div class="step-num">4</div><span>Pantau status dan terima notifikasi perkembangan laporan</span></li>
    </ul>
  </div>
  <div class="auth-right">
    <div class="auth-card">
      <h3>Buat Akun Baru</h3>
      <p class="subtitle">Sudah punya akun? <a href="{{ route('login') }}" class="link-primary">Masuk di sini</a></p>

      @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-3" style="font-size:.85rem;">
          @foreach($errors->all() as $e) {{ $e }}<br> @endforeach
        </div>
      @endif

      <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Nama Lengkap</label>
            <div class="input-icon-wrap">
              <i class="bi bi-person icon"></i>
              <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nama lengkap Anda" required/>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Alamat Email</label>
            <div class="input-icon-wrap">
              <i class="bi bi-envelope icon"></i>
              <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required/>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Nomor HP / WhatsApp</label>
            <div class="input-icon-wrap">
              <i class="bi bi-telephone icon"></i>
              <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required/>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Kelurahan / Kecamatan</label>
            <div class="input-icon-wrap">
              <i class="bi bi-house icon"></i>
              <select class="form-control" name="kelurahan">
                <option value="">-- Pilih Kelurahan --</option>
                @foreach(['Aur Tajungkang Tengah Sawah','Tarok Dipo','Campago Ipuh','Puhun Tembok','Benteng Pasar Atas','Belakang Balok','Kubu Gulai Bancah','Lainnya'] as $k)
                  <option value="{{ $k }}" {{ old('kelurahan') == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-12">
            <label class="form-label">Password</label>
            <div class="input-icon-wrap">
              <i class="bi bi-lock icon"></i>
              <input type="password" class="form-control" name="password" id="pw" placeholder="Min. 8 karakter" oninput="checkStrength(this.value)" required/>
              <i class="bi bi-eye toggle-pw" onclick="togglePw('pw')"></i>
            </div>
            <div class="pw-strength"><div class="pw-strength-bar" id="strengthBar"></div></div>
            <div class="strength-text text-muted" id="strengthText"></div>
          </div>
          <div class="col-12">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-icon-wrap">
              <i class="bi bi-lock-fill icon"></i>
              <input type="password" class="form-control" name="password_confirmation" id="pw2" placeholder="Ulangi password" required/>
              <i class="bi bi-eye toggle-pw" onclick="togglePw('pw2')"></i>
            </div>
          </div>
          <div class="col-12">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="agree" required/>
              <label class="form-check-label" for="agree" style="font-size:.83rem;">
                Saya setuju dengan <a href="#" class="link-primary">Syarat & Ketentuan</a>
              </label>
            </div>
          </div>
          <div class="col-12">
            <button type="submit" class="btn-primary-custom">
              <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
            </button>
          </div>
        </div>
      </form>
      <p class="text-center mt-3" style="font-size:.82rem;color:var(--text-muted);">
        <a href="{{ route('landing') }}" class="link-primary"><i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda</a>
      </p>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePw(id) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
  }
  function checkStrength(val) {
    const bar = document.getElementById('strengthBar');
    const txt = document.getElementById('strengthText');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
      {w:'0%',c:'#EF4444',t:''},
      {w:'25%',c:'#EF4444',t:'Lemah'},
      {w:'50%',c:'#F59E0B',t:'Cukup'},
      {w:'75%',c:'#3B82F6',t:'Kuat'},
      {w:'100%',c:'#10B981',t:'Sangat Kuat'},
    ];
    bar.style.width = levels[score].w;
    bar.style.background = levels[score].c;
    txt.textContent = levels[score].t;
    txt.style.color = levels[score].c;
  }
</script>
</body>
</html>