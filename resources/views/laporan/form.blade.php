@extends('layouts.app')
@section('title', 'Buat Laporan – LaporJalanRusak')

@push('styles')
<style>
  .page-header { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 32px 0; }
  .page-header h1 { color: #fff; font-size: 1.4rem; font-weight: 800; margin-bottom: 4px; }
  .breadcrumb { background: transparent; margin: 0; padding: 0; }
  .breadcrumb-item a { color: rgba(255,255,255,.7); text-decoration: none; font-size: .82rem; }
  .breadcrumb-item.active { color: rgba(255,255,255,.9); font-size: .82rem; }
  .breadcrumb-item+.breadcrumb-item::before { color: rgba(255,255,255,.5); }
  .main-content { padding: 32px 0 60px; }
  .card-form { background: #fff; border-radius: 16px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 20px; }
  .card-form-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; }
  .card-form-header .step-badge { width: 28px; height: 28px; border-radius: 50%; background: var(--primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: .78rem; font-weight: 700; flex-shrink: 0; }
  .card-form-header h6 { font-weight: 700; margin: 0; font-size: .95rem; }
  .card-form-header p { color: var(--text-muted); margin: 0; font-size: .8rem; }
  .card-form-body { padding: 24px; }
  .form-label { font-weight: 600; font-size: .83rem; margin-bottom: 5px; }
  .required { color: #EF4444; }
  .form-control, .form-select { border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: .88rem; transition: border-color .2s, box-shadow .2s; }
  .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,86,160,.1); outline: none; }
  .form-text { font-size: .78rem; color: var(--text-muted); margin-top: 4px; }
  .severity-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }
  .severity-option input { display: none; }
  .severity-label { border: 2px solid var(--border); border-radius: 12px; padding: 14px 10px; text-align: center; cursor: pointer; transition: all .2s; display: block; }
  .severity-option.ringan input:checked + .severity-label { border-color: #10B981; background: #D1FAE5; }
  .severity-option.sedang input:checked + .severity-label { border-color: #F59E0B; background: #FEF3C7; }
  .severity-option.parah input:checked + .severity-label { border-color: #EF4444; background: #FEE2E2; }
  .severity-label .sev-icon { font-size: 1.6rem; display: block; margin-bottom: 6px; }
  .severity-label span { font-size: .82rem; font-weight: 700; display: block; }
  .severity-label small { font-size: .72rem; color: var(--text-muted); }
  .photo-upload-area { border: 2px dashed var(--border); border-radius: 12px; padding: 32px; text-align: center; cursor: pointer; transition: border-color .2s; }
  .photo-upload-area:hover { border-color: var(--primary); }
  .photo-preview { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px; }
  .photo-preview-item { width: 80px; height: 80px; border-radius: 10px; object-fit: cover; border: 1.5px solid var(--border); }
  .map-placeholder { background: var(--light-bg); border: 1.5px solid var(--border); border-radius: 12px; height: 200px; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 8px; color: var(--text-muted); font-size: .88rem; }
  .btn-submit { background: var(--accent); color: #fff; border: none; border-radius: 10px; padding: 14px 36px; font-size: .95rem; font-weight: 700; transition: background .2s, transform .15s; }
  .btn-submit:hover { background: #e06010; transform: translateY(-1px); color: #fff; }
</style>
@endpush

@section('content')
<div class="page-header">
  <div class="container">
    <h1><i class="bi bi-plus-circle me-2"></i>Buat Laporan Kerusakan Jalan</h1>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Beranda</a></li>
        <li class="breadcrumb-item active">Buat Laporan</li>
      </ol>
    </nav>
  </div>
</div>

<div class="main-content">
  <div class="container">
    <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="row g-4">
        <div class="col-lg-8">

          <!-- Step 1: Data Pelapor -->
          <div class="card-form">
            <div class="card-form-header">
              <div class="step-badge">1</div>
              <div>
                <h6>Identitas Pelapor</h6>
                <p>Isi data diri pelapor</p>
              </div>
            </div>
            <div class="card-form-body">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                  <input type="text" class="form-control" name="nama_pelapor" value="{{ old('nama_pelapor', Auth::user()?->name) }}" placeholder="Nama lengkap Anda" required/>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Nomor HP / WhatsApp</label>
                  <input type="tel" class="form-control" name="telepon_pelapor" value="{{ old('telepon_pelapor', Auth::user()?->phone) }}" placeholder="08xxxxxxxxxx"/>
                </div>
              </div>
            </div>
          </div>

          <!-- Step 2: Info Kerusakan -->
          <div class="card-form">
            <div class="card-form-header">
              <div class="step-badge">2</div>
              <div>
                <h6>Informasi Kerusakan</h6>
                <p>Jelaskan jenis dan tingkat kerusakan jalan</p>
              </div>
            </div>
            <div class="card-form-body">
              <div class="mb-3">
                <label class="form-label">Jenis Kerusakan <span class="required">*</span></label>
                <select class="form-select" name="jenis_kerusakan" required>
                  <option value="">-- Pilih Jenis Kerusakan --</option>
                  <option {{ old('jenis_kerusakan')=='Jalan Berlubang'?'selected':'' }}>Jalan Berlubang</option>
                  <option {{ old('jenis_kerusakan')=='Retak/Pecah'?'selected':'' }}>Retak/Pecah</option>
                  <option {{ old('jenis_kerusakan')=='Jalan Longsor'?'selected':'' }}>Jalan Longsor</option>
                  <option {{ old('jenis_kerusakan')=='Aspal Terkelupas'?'selected':'' }}>Aspal Terkelupas</option>
                  <option {{ old('jenis_kerusakan')=='Drainase Tersumbat'?'selected':'' }}>Drainase Tersumbat</option>
                  <option {{ old('jenis_kerusakan')=='Lainnya'?'selected':'' }}>Lainnya</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Tingkat Kerusakan <span class="required">*</span></label>
                <div class="severity-grid">
                  <div class="severity-option ringan">
                    <input type="radio" name="tingkat_kerusakan" value="ringan" id="ringan" {{ old('tingkat_kerusakan')=='ringan'?'checked':'' }} required/>
                    <label class="severity-label" for="ringan">
                      <span class="sev-icon">🟡</span>
                      <span>Ringan</span>
                      <small>Retak kecil, tidak mengganggu</small>
                    </label>
                  </div>
                  <div class="severity-option sedang">
                    <input type="radio" name="tingkat_kerusakan" value="sedang" id="sedang" {{ old('tingkat_kerusakan')=='sedang'?'checked':'' }}/>
                    <label class="severity-label" for="sedang">
                      <span class="sev-icon">🟠</span>
                      <span>Sedang</span>
                      <small>Lubang, mengganggu lalu lintas</small>
                    </label>
                  </div>
                  <div class="severity-option parah">
                    <input type="radio" name="tingkat_kerusakan" value="parah" id="parah" {{ old('tingkat_kerusakan')=='parah'?'checked':'' }}/>
                    <label class="severity-label" for="parah">
                      <span class="sev-icon">🔴</span>
                      <span>Parah</span>
                      <small>Berbahaya, butuh segera</small>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-0">
                <label class="form-label">Deskripsi Kerusakan <span class="required">*</span></label>
                <textarea class="form-control" name="deskripsi" rows="4" placeholder="Jelaskan kondisi kerusakan secara detail..." required>{{ old('deskripsi') }}</textarea>
                <div class="form-text">Minimal 20 karakter. Jelaskan kondisi, ukuran kerusakan, dan dampaknya.</div>
              </div>
            </div>
          </div>

          <!-- Step 3: Lokasi -->
          <div class="card-form">
            <div class="card-form-header">
              <div class="step-badge">3</div>
              <div>
                <h6>Lokasi Kerusakan</h6>
                <p>Tentukan lokasi tepat kerusakan jalan</p>
              </div>
            </div>
            <div class="card-form-body">
              <div class="mb-3">
                <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                <textarea class="form-control" name="lokasi_lengkap" rows="2" placeholder="Contoh: Jl. Ahmad Yani, Depan Toko Budi, dekat persimpangan..." required>{{ old('lokasi_lengkap') }}</textarea>
              </div>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Kelurahan <span class="required">*</span></label>
                  <select class="form-select" name="kelurahan" required>
                    <option value="">-- Pilih Kelurahan --</option>
                    @foreach(['Aur Tajungkang Tengah Sawah','Tarok Dipo','Campago Ipuh','Puhun Tembok','Benteng Pasar Atas','Belakang Balok','Kubu Gulai Bancah','Lainnya'] as $k)
                      <option value="{{ $k }}" {{ old('kelurahan')==$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Kecamatan <span class="required">*</span></label>
                  <select class="form-select" name="kecamatan" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach(['Guguk Panjang','Mandiangin Koto Selayan','Aur Birugo Tigo Baleh'] as $k)
                      <option value="{{ $k }}" {{ old('kecamatan')==$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Latitude GPS</label>
                  <input type="number" step="any" class="form-control" name="latitude" id="lat" value="{{ old('latitude') }}" placeholder="-0.3086"/>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Longitude GPS</label>
                  <input type="number" step="any" class="form-control" name="longitude" id="lng" value="{{ old('longitude') }}" placeholder="100.3693"/>
                </div>
              </div>
              <button type="button" class="btn btn-outline-primary btn-sm mt-2" onclick="getLocation()">
                <i class="bi bi-geo-alt me-1"></i>Gunakan Lokasi Saya
              </button>
            </div>
          </div>

          <!-- Step 4: Foto -->
          <div class="card-form">
            <div class="card-form-header">
              <div class="step-badge">4</div>
              <div>
                <h6>Foto Kerusakan</h6>
                <p>Unggah foto sebagai bukti laporan (maks. 5 foto)</p>
              </div>
            </div>
            <div class="card-form-body">
              <div class="photo-upload-area" id="dropArea" onclick="document.getElementById('fotoGaleri').click()">
                <i class="bi bi-images" style="font-size:2rem;color:var(--primary);"></i>
                <p style="margin:8px 0 4px;font-weight:600;">Klik untuk unggah foto</p>
                <small style="color:var(--text-muted);">JPG, PNG, WEBP – Maks. 5MB per foto</small>
              </div>

              {{-- Tombol khusus HP: tampil hanya di perangkat mobile --}}
              <div class="d-flex gap-2 mt-2" id="mobilePhotoButtons" style="display:none!important;">
                <button type="button" class="btn btn-outline-primary flex-fill" style="border-radius:10px;font-size:.88rem;font-weight:600;"
                        onclick="document.getElementById('fotoKamera').click()">
                  <i class="bi bi-camera-fill me-2"></i>Buka Kamera
                </button>
                <button type="button" class="btn btn-outline-secondary flex-fill" style="border-radius:10px;font-size:.88rem;font-weight:600;"
                        onclick="document.getElementById('fotoGaleri').click()">
                  <i class="bi bi-folder2-open me-2"></i>Pilih dari Galeri
                </button>
              </div>

              {{-- Input kamera (HP: langsung buka kamera belakang) --}}
              <input type="file" id="fotoKamera" name="foto[]" multiple accept="image/*" capture="environment"
                     style="display:none" onchange="previewFoto(this)"/>
              {{-- Input galeri / file manager --}}
              <input type="file" id="fotoGaleri" name="foto[]" multiple accept="image/*"
                     style="display:none" onchange="previewFoto(this)"/>
              <div class="photo-preview" id="photoPreview"></div>
            </div>
          </div>

        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
          <div class="card-form" style="position:sticky;top:80px;">
            <div class="card-form-header">
              <i class="bi bi-info-circle" style="color:var(--primary);"></i>
              <div>
                <h6>Ringkasan Laporan</h6>
                <p>Pastikan semua data sudah benar</p>
              </div>
            </div>
            <div class="card-form-body">
              <div style="font-size:.82rem;color:var(--text-muted);line-height:1.8;">
                <p><i class="bi bi-check2 text-success me-1"></i>Laporan akan diterima oleh Dinas PU Bukittinggi</p>
                <p><i class="bi bi-check2 text-success me-1"></i>Kode laporan unik akan diberikan</p>
                <p><i class="bi bi-check2 text-success me-1"></i>Status dapat dipantau kapan saja</p>
              </div>
              <hr style="border-color:var(--border);"/>
              <button type="submit" class="btn-submit w-100">
                <i class="bi bi-send-fill me-2"></i>Kirim Laporan
              </button>
              <a href="{{ route('landing') }}" class="btn btn-light w-100 mt-2" style="border-radius:10px;font-weight:600;font-size:.88rem;">
                Batal
              </a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Koleksi foto dari kedua input (kamera + galeri), maks 5
  let allFiles = [];

  function previewFoto(input) {
    const newFiles = Array.from(input.files);
    newFiles.forEach(f => {
      if (allFiles.length < 5) allFiles.push(f);
    });
    // Reset input agar bisa pilih file yang sama lagi
    input.value = '';
    renderPreview();
  }

  function renderPreview() {
    const preview = document.getElementById('photoPreview');
    preview.innerHTML = '';
    allFiles.forEach((file, idx) => {
      const reader = new FileReader();
      reader.onload = e => {
        const wrap = document.createElement('div');
        wrap.style.cssText = 'position:relative;display:inline-block;';
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'photo-preview-item';
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.innerHTML = '<i class="bi bi-x"></i>';
        btn.style.cssText = 'position:absolute;top:4px;right:4px;background:rgba(0,0,0,.6);color:#fff;border:none;border-radius:50%;width:22px;height:22px;font-size:.75rem;display:flex;align-items:center;justify-content:center;cursor:pointer;padding:0;';
        btn.onclick = () => { allFiles.splice(idx, 1); renderPreview(); };
        wrap.appendChild(img);
        wrap.appendChild(btn);
        preview.appendChild(wrap);
      };
      reader.readAsDataURL(file);
    });
    // Sync file ke hidden input untuk dikirim ke server
    syncFilesToForm();
  }

  function syncFilesToForm() {
    // Buat DataTransfer untuk inject file ke input galeri (yang akan dikirim)
    const dt = new DataTransfer();
    allFiles.forEach(f => dt.items.add(f));
    document.getElementById('fotoGaleri').files = dt.files;
  }

  // Deteksi HP → tampilkan tombol kamera & galeri terpisah
  function isMobile() {
    return /Android|iPhone|iPad|iPod|Mobile/i.test(navigator.userAgent);
  }
  document.addEventListener('DOMContentLoaded', function() {
    if (isMobile()) {
      document.getElementById('mobilePhotoButtons').style.display = 'flex';
      // Di HP, area klik utama tetap buka galeri (sudah dikonfigurasi di onclick)
    }
  });

  function getLocation() {
    if (!navigator.geolocation) return alert('GPS tidak didukung.');
    navigator.geolocation.getCurrentPosition(pos => {
      document.getElementById('lat').value = pos.coords.latitude.toFixed(7);
      document.getElementById('lng').value = pos.coords.longitude.toFixed(7);
    }, () => alert('Gagal mendapatkan lokasi.'));
  }
</script>
@endpush