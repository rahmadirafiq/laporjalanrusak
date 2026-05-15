@extends('layouts.app')
@section('title', 'Riwayat Laporan – LaporJalanRusak')

@push('styles')
<style>
  .page-header { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 32px 0; }
  .page-header h1 { color: #fff; font-size: 1.4rem; font-weight: 800; }
  .breadcrumb { background: transparent; margin: 0; padding: 0; }
  .breadcrumb-item a { color: rgba(255,255,255,.7); text-decoration: none; font-size: .82rem; }
  .breadcrumb-item.active { color: rgba(255,255,255,.9); font-size: .82rem; }
  .breadcrumb-item+.breadcrumb-item::before { color: rgba(255,255,255,.5); }
  .stat-pill { background: rgba(255,255,255,.15); color: #fff; border-radius: 20px; padding: 6px 14px; font-size: .82rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
  .main-content { padding: 32px 0 60px; }
  .filter-bar { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; }
  .filter-bar .form-select, .filter-bar .form-control { border: 1.5px solid var(--border); border-radius: 10px; font-size: .85rem; padding: 9px 12px; }
  .report-card { background: #fff; border: 1.5px solid var(--border); border-radius: 16px; padding: 20px; text-decoration: none; color: inherit; display: block; transition: all .2s; margin-bottom: 16px; }
  .report-card:hover { border-color: var(--primary); box-shadow: 0 6px 24px rgba(26,86,160,.12); transform: translateY(-1px); }
  .report-kode { font-family: monospace; font-size: .78rem; font-weight: 700; color: var(--primary); background: var(--light-bg); padding: 2px 8px; border-radius: 6px; }
  .report-title { font-weight: 700; font-size: 1rem; margin: 8px 0 4px; }
  .report-meta { font-size: .8rem; color: var(--text-muted); }
  .report-meta span { margin-right: 14px; }
  .foto-thumb { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; border: 1.5px solid var(--border); }
  .foto-placeholder { width: 56px; height: 56px; border-radius: 10px; background: var(--light-bg); display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.3rem; }
</style>
@endpush

@section('content')
<div class="page-header">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3">
      <div>
        <h1><i class="bi bi-clock-history me-2"></i>Riwayat Laporan</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Riwayat Laporan</li>
          </ol>
        </nav>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <div class="stat-pill"><i class="bi bi-file-text"></i> {{ $stats['total'] }} Total</div>
        <div class="stat-pill"><i class="bi bi-check-circle"></i> {{ $stats['selesai'] }} Selesai</div>
        <div class="stat-pill"><i class="bi bi-tools"></i> {{ $stats['proses'] }} Diproses</div>
      </div>
    </div>
  </div>
</div>

<div class="main-content">
  <div class="container">
    <!-- Filter -->
    <div class="filter-bar">
      <form method="GET" action="{{ route('laporan.riwayat') }}">
        <div class="row g-3 align-items-end">
          <div class="col-md-5">
            <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:4px;">Cari Laporan</label>
            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Kode, lokasi, jenis kerusakan..."/>
          </div>
          <div class="col-md-3">
            <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:4px;">Status</label>
            <select class="form-select" name="status">
              <option value="">Semua Status</option>
              @foreach(['menunggu','diverifikasi','proses','selesai','ditolak'] as $s)
                <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;font-weight:600;font-size:.85rem;">
              <i class="bi bi-search me-1"></i>Filter
            </button>
          </div>
          <div class="col-md-2">
            <a href="{{ route('laporan.riwayat') }}" class="btn btn-light w-100" style="border-radius:10px;font-weight:600;font-size:.85rem;">Reset</a>
          </div>
        </div>
      </form>
    </div>

    <!-- List -->
    @forelse($laporans as $lap)
    <a href="{{ route('laporan.detail', $lap->id) }}" class="report-card">
      <div class="d-flex align-items-start gap-3">
        <div class="flex-shrink-0">
          @if($lap->foto && count($lap->foto) > 0)
            <img src="{{ asset('storage/' . $lap->foto[0]) }}" class="foto-thumb" alt="foto"/>
          @else
            <div class="foto-placeholder"><i class="bi bi-image"></i></div>
          @endif
        </div>
        <div class="flex-grow-1">
          <div class="d-flex align-items-center gap-2 mb-1">
            <span class="report-kode">{{ $lap->kode }}</span>
            <span class="status-badge {{ $lap->badge_class }}">{{ $lap->label_status }}</span>
            @if($lap->tingkat_kerusakan == 'parah')
              <span class="badge bg-danger" style="font-size:.7rem;">⚠ Parah</span>
            @endif
          </div>
          <div class="report-title">{{ $lap->jenis_kerusakan }}</div>
          <div class="report-meta">
            <span><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($lap->lokasi_lengkap, 50) }}</span>
            <span><i class="bi bi-calendar3 me-1"></i>{{ $lap->created_at->format('d M Y') }}</span>
          </div>
        </div>
        <div class="flex-shrink-0 d-none d-md-block">
          <i class="bi bi-chevron-right text-muted"></i>
        </div>
      </div>
    </a>
    @empty
    <div class="text-center py-5" style="color:var(--text-muted);">
      <i class="bi bi-inbox" style="font-size:3rem;"></i>
      <p class="mt-2 mb-3">Belum ada laporan</p>
      <a href="{{ route('laporan.form') }}" class="btn btn-primary" style="border-radius:10px;">Buat Laporan Pertama</a>
    </div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-3">
      {{ $laporans->withQueryString()->links() }}
    </div>
  </div>
</div>
@endsection