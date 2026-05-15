@extends('layouts.app')
@section('title', 'Detail Laporan ' . $laporan->kode . ' – LaporJalanRusak')

@push('styles')
<style>
  .page-header { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 28px 0; }
  .page-header h1 { color: #fff; font-size: 1.3rem; font-weight: 800; }
  .breadcrumb { background: transparent; margin: 0; padding: 0; }
  .breadcrumb-item a { color: rgba(255,255,255,.7); text-decoration: none; font-size: .82rem; }
  .breadcrumb-item.active { color: rgba(255,255,255,.9); font-size: .82rem; }
  .breadcrumb-item+.breadcrumb-item::before { color: rgba(255,255,255,.5); }
  .main-content { padding: 32px 0 60px; }
  .info-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 24px; margin-bottom: 20px; }
  .info-card h5 { font-weight: 700; font-size: .95rem; margin-bottom: 18px; color: var(--primary); }
  .detail-row { display: flex; padding: 10px 0; border-bottom: 1px solid var(--border); }
  .detail-row:last-child { border-bottom: none; }
  .detail-label { flex: 0 0 150px; font-size: .82rem; font-weight: 600; color: var(--text-muted); }
  .detail-value { flex: 1; font-size: .88rem; }
  .foto-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; }
  .foto-item { border-radius: 10px; overflow: hidden; aspect-ratio: 1; }
  .foto-item img { width: 100%; height: 100%; object-fit: cover; }
  .status-hero { border-radius: 16px; padding: 24px; margin-bottom: 20px; }
  .status-hero.menunggu    { background: #FEF3C7; }
  .status-hero.diverifikasi{ background: #DBEAFE; }
  .status-hero.proses      { background: #FEE2E2; }
  .status-hero.selesai     { background: #D1FAE5; }
  .status-hero.ditolak     { background: #F1F5F9; }
  .status-badge-lg { display: inline-block; padding: 8px 20px; border-radius: 20px; font-size: .9rem; font-weight: 700; background: rgba(255,255,255,.6); margin-bottom: 10px; }
  .meta { font-size: .82rem; color: var(--text-muted); }
  .meta span { margin-right: 16px; }
</style>
@endpush

@section('content')
<div class="page-header">
  <div class="container">
    <h1>Detail Laporan</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
        @auth <li class="breadcrumb-item"><a href="{{ route('laporan.riwayat') }}">Laporan Saya</a></li> @endauth
        <li class="breadcrumb-item active">{{ $laporan->kode }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="main-content">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        <!-- Status Hero -->
        <div class="status-hero {{ $laporan->status }}">
          <div class="status-badge-lg">{{ $laporan->label_status }}</div>
          <div class="meta">
            <span><i class="bi bi-hash"></i> {{ $laporan->kode }}</span>
            <span><i class="bi bi-calendar3"></i> {{ $laporan->created_at->format('d M Y') }}</span>
            <span><i class="bi bi-person-circle"></i> {{ $laporan->nama_pelapor }}</span>
          </div>
        </div>

        <!-- Info -->
        <div class="info-card">
          <h5><i class="bi bi-info-circle-fill me-2"></i>Informasi Laporan</h5>
          <div class="detail-row"><span class="detail-label">Lokasi</span><span class="detail-value">{{ $laporan->lokasi_lengkap }}</span></div>
          <div class="detail-row"><span class="detail-label">Kelurahan</span><span class="detail-value">{{ $laporan->kelurahan }}</span></div>
          <div class="detail-row"><span class="detail-label">Kecamatan</span><span class="detail-value">{{ $laporan->kecamatan }}</span></div>
          <div class="detail-row"><span class="detail-label">Jenis Kerusakan</span><span class="detail-value">{{ $laporan->jenis_kerusakan }}</span></div>
          <div class="detail-row">
            <span class="detail-label">Tingkat</span>
            <span class="detail-value">
              @if($laporan->tingkat_kerusakan == 'ringan') 🟡 Ringan
              @elseif($laporan->tingkat_kerusakan == 'sedang') 🟠 Sedang
              @else 🔴 Parah @endif
            </span>
          </div>
          @if($laporan->latitude)
          <div class="detail-row">
            <span class="detail-label">Koordinat GPS</span>
            <span class="detail-value">{{ $laporan->latitude }}, {{ $laporan->longitude }}</span>
          </div>
          @endif
          <div class="detail-row"><span class="detail-label">Deskripsi</span><span class="detail-value">{{ $laporan->deskripsi }}</span></div>
        </div>

        <!-- Foto -->
        @if($laporan->foto && count($laporan->foto) > 0)
        <div class="info-card">
          <h5><i class="bi bi-images me-2"></i>Foto Kerusakan</h5>
          <div class="foto-grid">
            @foreach($laporan->foto as $foto)
            <div class="foto-item">
              <img src="{{ asset('storage/' . $foto) }}" alt="Foto kerusakan"/>
            </div>
            @endforeach
          </div>
        </div>
        @endif

        @if($laporan->catatan_admin)
        <div class="info-card">
          <h5><i class="bi bi-chat-text-fill me-2"></i>Catatan dari Admin</h5>
          <p style="font-size:.88rem;margin:0;">{{ $laporan->catatan_admin }}</p>
        </div>
        @endif
      </div>

      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="info-card">
          <h5><i class="bi bi-person-fill me-2"></i>Data Pelapor</h5>
          <div class="detail-row"><span class="detail-label">Nama</span><span class="detail-value">{{ $laporan->nama_pelapor }}</span></div>
          @if($laporan->telepon_pelapor)
          <div class="detail-row"><span class="detail-label">Telepon</span><span class="detail-value">{{ $laporan->telepon_pelapor }}</span></div>
          @endif
        </div>

        @auth
        @if($laporan->user_id == Auth::id())
        <div class="info-card">
          <h5><i class="bi bi-gear-fill me-2"></i>Aksi</h5>
          <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus laporan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger w-100" style="border-radius:10px;font-size:.85rem;font-weight:600;">
              <i class="bi bi-trash me-2"></i>Hapus Laporan
            </button>
          </form>
        </div>
        @endif
        @endauth

        <div class="info-card">
          <a href="{{ Auth::check() ? route('laporan.riwayat') : route('landing') }}" class="btn btn-outline-primary w-100" style="border-radius:10px;font-size:.85rem;font-weight:600;">
            <i class="bi bi-arrow-left me-2"></i>Kembali
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection