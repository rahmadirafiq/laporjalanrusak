@extends('layouts.app')
@section('title', 'Profil – LaporJalanRusak')

@push('styles')
<style>
  .profile-header { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); padding: 40px 0 32px; text-align: center; }
  .avatar-lg { width: 80px; height: 80px; border-radius: 50%; background: rgba(255,255,255,.2); border: 3px solid rgba(255,255,255,.4); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.8rem; color: #fff; margin: 0 auto 12px; }
  .profile-header h2 { color: #fff; font-weight: 800; font-size: 1.4rem; margin-bottom: 4px; }
  .profile-header p { color: rgba(255,255,255,.75); font-size: .85rem; }
  .profile-stat { background: rgba(255,255,255,.15); border-radius: 12px; padding: 14px 10px; text-align: center; }
  .profile-stat .num { display: block; font-size: 1.5rem; font-weight: 800; color: #fff; }
  .profile-stat .label { font-size: .75rem; color: rgba(255,255,255,.75); }
  .main-content { padding: 32px 0 60px; }
  .sidebar-nav { background: #fff; border: 1px solid var(--border); border-radius: 16px; overflow: hidden; }
  .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 14px 20px; text-decoration: none; color: var(--text-dark); font-size: .88rem; font-weight: 600; border-left: 3px solid transparent; transition: all .2s; }
  .sidebar-nav a:hover, .sidebar-nav a.active { background: var(--light-bg); border-left-color: var(--primary); color: var(--primary); }
  .sidebar-nav a i { font-size: 1rem; }
  .section-card { background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 28px; margin-bottom: 20px; }
  .section-card h5 { font-weight: 700; font-size: 1rem; margin-bottom: 20px; }
  .form-label { font-weight: 600; font-size: .83rem; margin-bottom: 5px; }
  .form-control, .form-select { border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px; font-size: .88rem; transition: border-color .2s; }
  .form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(26,86,160,.1); outline: none; }
  .input-icon-wrap { position: relative; }
  .input-icon-wrap .form-control { padding-left: 42px; }
  .input-icon-wrap .icon { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: .95rem; }
  .btn-save { background: var(--primary); color: #fff; border: none; border-radius: 10px; padding: 11px 28px; font-weight: 700; font-size: .88rem; }
  .btn-save:hover { background: var(--primary-dark); color: #fff; }
  .form-switch .form-check-input { width: 42px; height: 22px; cursor: pointer; }
  .form-switch .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
</style>
@endpush

@section('content')
<div class="profile-header">
  <div class="container">
    <div class="avatar-lg">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
    <h2>{{ $user->name }}</h2>
    <p><i class="bi bi-geo-alt me-1"></i>{{ $user->kelurahan ?? 'Bukittinggi' }} · Bergabung {{ $user->created_at->format('M Y') }}</p>
    <div class="row g-3 mt-2 justify-content-center" style="max-width:400px;margin-left:auto;margin-right:auto;">
      <div class="col-4"><div class="profile-stat"><span class="num">{{ $stats['total'] }}</span><span class="label">Total Laporan</span></div></div>
      <div class="col-4"><div class="profile-stat"><span class="num">{{ $stats['selesai'] }}</span><span class="label">Selesai</span></div></div>
      <div class="col-4"><div class="profile-stat"><span class="num">{{ $stats['proses'] }}</span><span class="label">Diproses</span></div></div>
    </div>
  </div>
</div>

<div class="main-content">
  <div class="container">
    <div class="row g-4">
      <!-- Sidebar -->
      <div class="col-lg-3">
        <div class="sidebar-nav">
          <a href="#profil" class="active"><i class="bi bi-person"></i>Data Pribadi</a>
          <a href="#password"><i class="bi bi-lock"></i>Ubah Password</a>
          <a href="#notifikasi"><i class="bi bi-bell"></i>Notifikasi</a>
          <a href="{{ route('laporan.riwayat') }}"><i class="bi bi-clock-history"></i>Riwayat Laporan</a>
        </div>
      </div>

      <!-- Main -->
      <div class="col-lg-9">

        <!-- Data Pribadi -->
        <div class="section-card" id="profil">
          <h5><i class="bi bi-person-fill me-2" style="color:var(--primary);"></i>Data Pribadi</h5>
          <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-person icon"></i>
                  <input type="text" class="form-control" name="name" value="{{ $user->name }}" required/>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-envelope icon"></i>
                  <input type="email" class="form-control" name="email" value="{{ $user->email }}" required/>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Nomor HP / WhatsApp</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-telephone icon"></i>
                  <input type="tel" class="form-control" name="phone" value="{{ $user->phone }}"/>
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Kelurahan</label>
                <div class="input-icon-wrap">
                  <i class="bi bi-house icon"></i>
                  <select class="form-control" name="kelurahan">
                    @foreach(['Aur Tajungkang Tengah Sawah','Tarok Dipo','Campago Ipuh','Puhun Tembok','Benteng Pasar Atas','Belakang Balok','Kubu Gulai Bancah','Lainnya'] as $k)
                      <option value="{{ $k }}" {{ $user->kelurahan == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn-save"><i class="bi bi-floppy me-2"></i>Simpan Perubahan</button>
              </div>
            </div>
          </form>
        </div>

        <!-- Ubah Password -->
        <div class="section-card" id="password">
          <h5><i class="bi bi-lock-fill me-2" style="color:var(--primary);"></i>Ubah Password</h5>
          <form action="{{ route('profil.password') }}" method="POST">
            @csrf
            <div class="row g-3">
              <div class="col-md-12">
                <label class="form-label">Password Saat Ini</label>
                <input type="password" class="form-control" name="current_password" placeholder="Password saat ini" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-control" name="password" placeholder="Min. 8 karakter" required/>
              </div>
              <div class="col-md-6">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password baru" required/>
              </div>
              <div class="col-12">
                <button type="submit" class="btn-save"><i class="bi bi-shield-lock me-2"></i>Ubah Password</button>
              </div>
            </div>
          </form>
        </div>

        <!-- Notifikasi -->
        <div class="section-card" id="notifikasi">
          <h5><i class="bi bi-bell-fill me-2" style="color:var(--primary);"></i>Pengaturan Notifikasi</h5>
          <form action="{{ route('profil.notifikasi') }}" method="POST">
            @csrf
            <div class="d-flex align-items-center justify-content-between py-3" style="border-bottom:1px solid var(--border);">
              <div>
                <div style="font-weight:600;font-size:.88rem;">Notifikasi Email</div>
                <div style="font-size:.78rem;color:var(--text-muted);">Terima pembaruan status via email</div>
              </div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="notif_email" {{ $user->notif_email ? 'checked' : '' }}/>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between py-3">
              <div>
                <div style="font-weight:600;font-size:.88rem;">Notifikasi WhatsApp</div>
                <div style="font-size:.78rem;color:var(--text-muted);">Terima pembaruan status via WhatsApp</div>
              </div>
              <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" name="notif_whatsapp" {{ $user->notif_whatsapp ? 'checked' : '' }}/>
              </div>
            </div>
            <button type="submit" class="btn-save mt-2"><i class="bi bi-floppy me-2"></i>Simpan Notifikasi</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection