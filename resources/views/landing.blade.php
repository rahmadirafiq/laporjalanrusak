@extends('layouts.app')
@section('title', 'Beranda – LaporJalanRusak')

@push('styles')
<style>
  .hero { background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, #2563EB 100%); padding: 80px 0 60px; }
  .hero h1 { font-family: 'Lora', serif; font-size: 2.6rem; font-weight: 700; color: #fff; margin-bottom: 18px; }
  .hero p { color: rgba(255,255,255,.8); font-size: 1rem; line-height: 1.8; margin-bottom: 32px; }
  .hero-badge { display: inline-flex; align-items: center; gap: 8px; background: rgba(255,255,255,.15); color: #fff; padding: 8px 16px; border-radius: 20px; font-size: .82rem; font-weight: 600; margin-bottom: 20px; }
  .btn-hero-primary { background: var(--accent); color: #fff; border: none; border-radius: 10px; padding: 14px 28px; font-weight: 700; font-size: .95rem; text-decoration: none; display: inline-flex; align-items: center; }
  .btn-hero-primary:hover { background: #e06010; color: #fff; }
  .btn-hero-secondary { background: rgba(255,255,255,.15); color: #fff; border: 1.5px solid rgba(255,255,255,.3); border-radius: 10px; padding: 14px 28px; font-weight: 700; font-size: .95rem; text-decoration: none; display: inline-flex; align-items: center; }
  .btn-hero-secondary:hover { background: rgba(255,255,255,.25); color: #fff; }
  .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }
  .stats-section { background: #fff; padding: 40px 0; border-bottom: 1px solid var(--border); }
  .stat-item { text-align: center; }
  .stat-item .num { display: block; font-size: 2rem; font-weight: 800; color: var(--primary); }
  .stat-item .label { font-size: .85rem; color: var(--text-muted); }
  .features-section { padding: 60px 0; }
  .feature-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 28px; text-align: center; height: 100%; }
  .feature-icon { width: 56px; height: 56px; border-radius: 14px; background: var(--light-bg); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--primary); margin: 0 auto 16px; }
  .feature-card h5 { font-weight: 700; margin-bottom: 10px; }
  .feature-card p { color: var(--text-muted); font-size: .88rem; line-height: 1.7; }
  .cta-section { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 60px 0; text-align: center; }
  .cta-section h2 { font-family: 'Lora', serif; color: #fff; font-size: 2rem; margin-bottom: 14px; }
  .cta-section p { color: rgba(255,255,255,.8); margin-bottom: 28px; }
  footer { background: var(--text-dark); color: rgba(255,255,255,.6); padding: 24px 0; text-align: center; font-size: .85rem; }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <div class="hero-badge"><i class="bi bi-shield-check-fill"></i> Platform Resmi Pelaporan Infrastruktur</div>
        <h1>Laporkan Kerusakan Jalan di Bukittinggi</h1>
        <p>LaporJalanRusak adalah platform digital yang menghubungkan masyarakat Kota Bukittinggi dengan Dinas Pekerjaan Umum untuk penanganan infrastruktur yang lebih cepat dan transparan.</p>
        <div class="hero-actions">
          <a href="{{ route('laporan.form') }}" class="btn-hero-primary">
            <i class="bi bi-plus-circle me-2"></i>Buat Laporan Sekarang
          </a>
          @auth
          <a href="{{ route('laporan.riwayat') }}" class="btn-hero-secondary">
            <i class="bi bi-clock-history me-2"></i>Laporan Saya
          </a>
          @else
          <a href="{{ route('login') }}" class="btn-hero-secondary">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk Akun
          </a>
          @endauth
        </div>
      </div>
      <div class="col-lg-6 text-center d-none d-lg-block">
        <div style="background:rgba(255,255,255,.1);border-radius:20px;padding:40px;display:inline-block;">
          <i class="bi bi-map-fill" style="font-size:6rem;color:rgba(255,255,255,.8);"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Stats -->
<section class="stats-section">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3"><div class="stat-item"><span class="num">{{ \App\Models\Laporan::count() }}</span><span class="label">Total Laporan</span></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><span class="num">{{ \App\Models\Laporan::where('status','selesai')->count() }}</span><span class="label">Selesai Diperbaiki</span></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><span class="num">{{ \App\Models\Laporan::where('status','proses')->count() }}</span><span class="label">Sedang Diproses</span></div></div>
      <div class="col-6 col-md-3"><div class="stat-item"><span class="num">{{ \App\Models\User::count() }}</span><span class="label">Warga Bergabung</span></div></div>
    </div>
  </div>
</section>

<!-- Features -->
<section class="features-section">
  <div class="container">
    <div class="text-center mb-48" style="margin-bottom:40px;">
      <h2 style="font-family:'Lora',serif;font-weight:700;font-size:1.8rem;margin-bottom:10px;">Cara Kerja Platform</h2>
      <p style="color:var(--text-muted);">Mudah, cepat, dan transparan untuk semua warga Bukittinggi</p>
    </div>
    <div class="row g-4">
      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-camera-fill"></i></div>
          <h5>Foto & Lokasi</h5>
          <p>Ambil foto kerusakan dan tandai lokasi tepat menggunakan GPS otomatis di perangkat Anda.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-send-fill"></i></div>
          <h5>Kirim Laporan</h5>
          <p>Isi formulir laporan lengkap dengan keterangan kerusakan dan kirimkan ke sistem kami.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-gear-fill"></i></div>
          <h5>Diproses Dinas</h5>
          <p>Tim Dinas PU Bukittinggi akan memverifikasi dan menindaklanjuti laporan Anda segera.</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="feature-card">
          <div class="feature-icon"><i class="bi bi-check-circle-fill"></i></div>
          <h5>Selesai & Notifikasi</h5>
          <p>Dapatkan notifikasi otomatis setiap ada pembaruan status hingga perbaikan selesai.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <h2>Siap Berkontribusi?</h2>
    <p>Buat laporan pertama Anda sekarang dan bantu Bukittinggi lebih baik.</p>
    <a href="{{ route('laporan.form') }}" class="btn-hero-primary" style="display:inline-flex;">
      <i class="bi bi-plus-circle me-2"></i>Buat Laporan Sekarang
    </a>
  </div>
</section>

<footer>
  <div class="container">
    <p class="mb-0">&copy; {{ date('Y') }} LaporJalanRusak – Platform Pelaporan Infrastruktur Kota Bukittinggi</p>
  </div>
</footer>
@endsection