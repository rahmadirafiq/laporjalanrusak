@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
  .chart-card { background:#fff; border:1px solid var(--border); border-radius:16px; padding:24px; }
  .recent-card { background:#fff; border:1px solid var(--border); border-radius:16px; overflow:hidden; }
  .recent-card .card-header-custom { padding:16px 20px; border-bottom:1px solid var(--border); font-weight:700; font-size:.9rem; display:flex; align-items:center; justify-content:space-between; }
</style>
@endpush

@section('content')
<!-- Stats -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <div class="icon-wrap" style="background:#EFF6FF;color:var(--primary);"><i class="bi bi-file-text-fill"></i></div>
      </div>
      <div class="num" style="color:var(--primary);">{{ $stats['total'] }}</div>
      <div class="label">Total Laporan</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <div class="icon-wrap" style="background:#FEF3C7;color:#92400E;"><i class="bi bi-hourglass-split"></i></div>
      </div>
      <div class="num" style="color:#92400E;">{{ $stats['menunggu'] }}</div>
      <div class="label">Menunggu Verifikasi</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <div class="icon-wrap" style="background:#FEE2E2;color:#991B1B;"><i class="bi bi-tools"></i></div>
      </div>
      <div class="num" style="color:#991B1B;">{{ $stats['proses'] }}</div>
      <div class="label">Dalam Proses</div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="stat-card">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <div class="icon-wrap" style="background:#D1FAE5;color:#065F46;"><i class="bi bi-check-circle-fill"></i></div>
      </div>
      <div class="num" style="color:#065F46;">{{ $stats['selesai'] }}</div>
      <div class="label">Selesai</div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Chart -->
  <div class="col-lg-7">
    <div class="chart-card">
      <div style="font-weight:700;font-size:.92rem;margin-bottom:18px;">
        <i class="bi bi-bar-chart-fill me-2" style="color:var(--primary);"></i>
        Laporan Per Bulan {{ date('Y') }}
      </div>
      <canvas id="chartBulan" height="100"></canvas>
    </div>
  </div>

  <!-- Status breakdown -->
  <div class="col-lg-5">
    <div class="chart-card h-100">
      <div style="font-weight:700;font-size:.92rem;margin-bottom:18px;">
        <i class="bi bi-pie-chart-fill me-2" style="color:var(--primary);"></i>
        Distribusi Status
      </div>
      <canvas id="chartStatus" height="160"></canvas>
    </div>
  </div>
</div>

<!-- Laporan Terbaru -->
<div class="recent-card mt-4">
  <div class="card-header-custom">
    <span><i class="bi bi-clock-history me-2" style="color:var(--primary);"></i>Laporan Terbaru</span>
    <a href="{{ route('admin.laporan.index') }}" style="font-size:.82rem;color:var(--primary);text-decoration:none;font-weight:600;">Lihat Semua →</a>
  </div>
  <div class="table-responsive">
    <table class="table data-table" style="border:none;">
      <thead>
        <tr>
          <th>Kode</th><th>Pelapor</th><th>Jenis</th><th>Lokasi</th><th>Status</th><th>Tanggal</th><th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($laporanTerbaru as $lap)
        <tr>
          <td><code style="font-size:.78rem;color:var(--primary);">{{ $lap->kode }}</code></td>
          <td style="font-weight:600;">{{ $lap->nama_pelapor }}</td>
          <td>{{ $lap->jenis_kerusakan }}</td>
          <td style="color:var(--text-muted);">{{ Str::limit($lap->lokasi_lengkap, 35) }}</td>
          <td><span class="status-badge {{ $lap->badge_class }}">{{ $lap->label_status }}</span></td>
          <td style="color:var(--text-muted);">{{ $lap->created_at->format('d M') }}</td>
          <td>
            <a href="{{ route('admin.laporan.detail', $lap->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-size:.75rem;">Detail</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  @php
    $chartDataJson    = json_encode($chartData);
    $statsMenunggu    = $stats['menunggu'];
    $statsDiverifikasi= $stats['diverifikasi'];
    $statsProses      = $stats['proses'];
    $statsSelesai     = $stats['selesai'];
    $statsDitolak     = $stats['ditolak'];
  @endphp

  var chartBulanData = <?php echo $chartDataJson; ?>;
  var chartStatusData = [
    <?php echo $statsMenunggu; ?>,
    <?php echo $statsDiverifikasi; ?>,
    <?php echo $statsProses; ?>,
    <?php echo $statsSelesai; ?>,
    <?php echo $statsDitolak; ?>
  ];

  // Chart per bulan
  new Chart(document.getElementById('chartBulan'), {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
      datasets: [{
        label: 'Jumlah Laporan',
        data: chartBulanData,
        backgroundColor: 'rgba(26,86,160,0.8)',
        borderRadius: 8,
      }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
  });

  // Chart status
  new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
      labels: ['Menunggu','Diverifikasi','Proses','Selesai','Ditolak'],
      datasets: [{
        data: chartStatusData,
        backgroundColor: ['#F59E0B','#3B82F6','#EF4444','#10B981','#94A3B8'],
        borderWidth: 0,
      }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { font: { size: 12 } } } }, cutout: '65%' }
  });
</script>
@endpush