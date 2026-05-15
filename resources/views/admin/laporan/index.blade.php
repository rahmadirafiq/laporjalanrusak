@extends('admin.layouts.app')
@section('title', 'Kelola Laporan')
@section('page-title', 'Kelola Laporan')

@section('content')
<!-- Stats -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card text-center">
      <div class="num" style="color:var(--primary);">{{ $stats['total'] }}</div>
      <div class="label">Total</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card text-center">
      <div class="num" style="color:#92400E;">{{ $stats['menunggu'] }}</div>
      <div class="label">Menunggu</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card text-center">
      <div class="num" style="color:#991B1B;">{{ $stats['proses'] }}</div>
      <div class="label">Diproses</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card text-center">
      <div class="num" style="color:#065F46;">{{ $stats['selesai'] }}</div>
      <div class="label">Selesai</div>
    </div>
  </div>
</div>

<!-- Filter -->
<div class="filter-bar">
  <form method="GET" action="{{ route('admin.laporan.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-4">
        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari kode, pelapor, lokasi..."/>
      </div>
      <div class="col-md-2">
        <select class="form-select" name="status">
          <option value="">Semua Status</option>
          @foreach(['menunggu','diverifikasi','proses','selesai','ditolak'] as $s)
            <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select class="form-select" name="tingkat">
          <option value="">Semua Tingkat</option>
          <option value="ringan" {{ request('tingkat')=='ringan'?'selected':'' }}>Ringan</option>
          <option value="sedang" {{ request('tingkat')=='sedang'?'selected':'' }}>Sedang</option>
          <option value="parah"  {{ request('tingkat')=='parah'?'selected':'' }}>Parah</option>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;font-size:.85rem;font-weight:600;">
          <i class="bi bi-search me-1"></i>Filter
        </button>
      </div>
      <div class="col-md-2">
        <a href="{{ route('admin.laporan.export') }}?{{ http_build_query(request()->only('status','tingkat')) }}"
           class="btn btn-success w-100" style="border-radius:10px;font-size:.85rem;font-weight:600;">
          <i class="bi bi-download me-1"></i>Export CSV
        </a>
      </div>
    </div>
  </form>
</div>

<!-- Tabel -->
<div class="data-table">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Kode</th><th>Pelapor</th><th>Jenis Kerusakan</th>
          <th>Lokasi</th><th>Tingkat</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($laporans as $lap)
        <tr>
          <td><code style="font-size:.78rem;color:var(--primary);">{{ $lap->kode }}</code></td>
          <td>
            <div style="font-weight:600;font-size:.85rem;">{{ $lap->nama_pelapor }}</div>
            <div style="font-size:.75rem;color:var(--text-muted);">{{ $lap->telepon_pelapor }}</div>
          </td>
          <td>{{ $lap->jenis_kerusakan }}</td>
          <td style="font-size:.82rem;color:var(--text-muted);">{{ Str::limit($lap->lokasi_lengkap, 40) }}</td>
          <td>
            @if($lap->tingkat_kerusakan=='ringan') <span style="color:#059669;font-weight:700;font-size:.8rem;">🟡 Ringan</span>
            @elseif($lap->tingkat_kerusakan=='sedang') <span style="color:#D97706;font-weight:700;font-size:.8rem;">🟠 Sedang</span>
            @else <span style="color:#DC2626;font-weight:700;font-size:.8rem;">🔴 Parah</span>
            @endif
          </td>
          <td><span class="status-badge {{ $lap->badge_class }}">{{ $lap->label_status }}</span></td>
          <td style="font-size:.8rem;color:var(--text-muted);">{{ $lap->created_at->format('d M Y') }}</td>
          <td>
            <a href="{{ route('admin.laporan.detail', $lap->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-size:.75rem;">
              <i class="bi bi-eye"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center py-4" style="color:var(--text-muted);">Tidak ada laporan ditemukan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="p-3">
    {{ $laporans->withQueryString()->links() }}
  </div>
</div>
@endsection