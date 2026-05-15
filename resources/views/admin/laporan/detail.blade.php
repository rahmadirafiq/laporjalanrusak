@extends('admin.layouts.app')
@section('title', 'Detail ' . $laporan->kode)
@section('page-title', 'Detail Laporan')

@push('styles')
<style>
  .info-card { background:#fff; border:1px solid var(--border); border-radius:16px; padding:24px; margin-bottom:20px; }
  .info-card h6 { font-weight:700; color:var(--primary); margin-bottom:16px; font-size:.9rem; }
  .detail-row { display:flex; padding:9px 0; border-bottom:1px solid var(--border); }
  .detail-row:last-child { border-bottom:none; }
  .detail-label { flex:0 0 140px; font-size:.8rem; font-weight:600; color:var(--text-muted); }
  .detail-value { flex:1; font-size:.85rem; }
  .foto-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(100px,1fr)); gap:10px; }
  .foto-grid img { width:100%; aspect-ratio:1; object-fit:cover; border-radius:10px; border:1.5px solid var(--border); cursor:zoom-in; transition:transform .2s,box-shadow .2s; }
  .foto-grid img:hover { transform:scale(1.04); box-shadow:0 4px 16px rgba(0,0,0,.18); }
  /* Lightbox */
  #lightboxModal .modal-dialog { max-width:90vw; max-height:90vh; }
  #lightboxModal .modal-content { background:#000; border:none; border-radius:16px; }
  #lightboxModal img { max-width:100%; max-height:82vh; object-fit:contain; border-radius:12px; display:block; margin:auto; }
</style>
@endpush

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
  <a href="{{ route('admin.laporan.index') }}" class="btn btn-light" style="border-radius:10px;font-size:.85rem;">
    <i class="bi bi-arrow-left me-1"></i>Kembali
  </a>
  <div>
    <code style="font-size:.88rem;color:var(--primary);font-weight:700;">{{ $laporan->kode }}</code>
    <span class="status-badge {{ $laporan->badge_class }} ms-2">{{ $laporan->label_status }}</span>
  </div>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="info-card">
      <h6><i class="bi bi-info-circle-fill me-2"></i>Informasi Laporan</h6>
      <div class="detail-row"><span class="detail-label">Jenis</span><span class="detail-value">{{ $laporan->jenis_kerusakan }}</span></div>
      <div class="detail-row">
        <span class="detail-label">Tingkat</span>
        <span class="detail-value">
          @if($laporan->tingkat_kerusakan=='ringan') 🟡 Ringan
          @elseif($laporan->tingkat_kerusakan=='sedang') 🟠 Sedang
          @else 🔴 Parah @endif
        </span>
      </div>
      <div class="detail-row"><span class="detail-label">Lokasi</span><span class="detail-value">{{ $laporan->lokasi_lengkap }}</span></div>
      <div class="detail-row"><span class="detail-label">Kelurahan</span><span class="detail-value">{{ $laporan->kelurahan }}</span></div>
      <div class="detail-row"><span class="detail-label">Kecamatan</span><span class="detail-value">{{ $laporan->kecamatan }}</span></div>
      @if($laporan->latitude)
      <div class="detail-row"><span class="detail-label">GPS</span><span class="detail-value">
        {{ $laporan->latitude }}, {{ $laporan->longitude }}
        <a href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}"
           target="_blank" rel="noopener"
           style="margin-left:8px;display:inline-flex;align-items:center;gap:4px;font-size:.78rem;font-weight:600;color:#1A56A0;background:#EFF6FF;border:1px solid #BFDBFE;border-radius:6px;padding:2px 8px;text-decoration:none;"
           title="Buka di Google Maps">
          <i class="bi bi-map-fill"></i> Maps
        </a>
      </span></div>
      @endif
      <div class="detail-row"><span class="detail-label">Deskripsi</span><span class="detail-value">{{ $laporan->deskripsi }}</span></div>
      <div class="detail-row"><span class="detail-label">Tanggal Lapor</span><span class="detail-value">{{ $laporan->created_at->format('d M Y, H:i') }} WIB</span></div>
    </div>

    @if($laporan->foto && count($laporan->foto) > 0)
    <div class="info-card">
      <h6><i class="bi bi-images me-2"></i>Foto Kerusakan ({{ count($laporan->foto) }} foto)</h6>
      <div class="foto-grid">
        @foreach($laporan->foto as $foto)
        <img src="{{ asset('storage/' . $foto) }}" alt="foto"
             data-bs-toggle="modal" data-bs-target="#lightboxModal"
             onclick="document.getElementById('lightboxImg').src=this.src"/>
        @endforeach
      </div>

    </div>
    @endif

    {{-- Lightbox Modal --}}
    <div class="modal fade" id="lightboxModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered" style="max-width:90vw;">
        <div class="modal-content p-2" style="background:#111;border:none;border-radius:16px;">
          <div class="d-flex justify-content-end mb-2">
            <button class="btn btn-sm btn-outline-light" data-bs-dismiss="modal" style="border-radius:8px;">
              <i class="bi bi-x-lg"></i> Tutup
            </button>
          </div>
          <img id="lightboxImg" src="" alt="Foto Fullscreen"
               style="max-width:100%;max-height:80vh;object-fit:contain;border-radius:10px;display:block;margin:auto;"/>
        </div>
      </div>
    </div>
  </div>{{-- end col-lg-7 --}}

  <div class="col-lg-5">
    <!-- Data Pelapor -->
    <div class="info-card">
      <h6><i class="bi bi-person-fill me-2"></i>Data Pelapor</h6>
      <div class="detail-row"><span class="detail-label">Nama</span><span class="detail-value">{{ $laporan->nama_pelapor }}</span></div>
      <div class="detail-row"><span class="detail-label">Telepon</span><span class="detail-value">{{ $laporan->telepon_pelapor ?? '-' }}</span></div>
      @if($laporan->user)
      <div class="detail-row"><span class="detail-label">Akun</span><span class="detail-value">{{ $laporan->user->email }}</span></div>
      @else
      <div class="detail-row"><span class="detail-label">Akun</span><span class="detail-value" style="color:var(--text-muted);">Tamu (tidak login)</span></div>
      @endif
    </div>

    <!-- Update Status -->
    <div class="info-card">
      <h6><i class="bi bi-arrow-repeat me-2"></i>Perbarui Status</h6>
      <form action="{{ route('admin.laporan.status', $laporan->id) }}" method="POST">
        @csrf
        <div class="mb-3">
          <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:5px;">Status Laporan</label>
          <select class="form-select" name="status" style="border:1.5px solid var(--border);border-radius:10px;font-size:.88rem;">
            @foreach(['menunggu','diverifikasi','proses','selesai','ditolak'] as $s)
              <option value="{{ $s }}" {{ $laporan->status==$s?'selected':'' }}>
                {{ ['menunggu'=>'Menunggu Verifikasi','diverifikasi'=>'Telah Diverifikasi','proses'=>'Dalam Proses Perbaikan','selesai'=>'Selesai','ditolak'=>'Ditolak'][$s] }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:5px;">Catatan Admin</label>
          <textarea class="form-control" name="catatan_admin" rows="3"
            style="border:1.5px solid var(--border);border-radius:10px;font-size:.85rem;"
            placeholder="Tambahkan catatan untuk pelapor...">{{ $laporan->catatan_admin }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;font-weight:700;font-size:.88rem;">
          <i class="bi bi-save me-2"></i>Simpan Status
        </button>
      </form>
    </div>

    <!-- Hapus -->
    <div class="info-card">
      <h6><i class="bi bi-trash-fill me-2" style="color:#DC2626;"></i>Hapus Laporan</h6>
      <p style="font-size:.82rem;color:var(--text-muted);margin-bottom:12px;">Tindakan ini tidak dapat dibatalkan. Semua foto terkait juga akan dihapus.</p>
      <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Yakin hapus laporan {{ $laporan->kode }}?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger w-100" style="border-radius:10px;font-size:.85rem;font-weight:600;">
          <i class="bi bi-trash me-2"></i>Hapus Laporan Ini
        </button>
      </form>
    </div>
  </div>
</div>
@endsection