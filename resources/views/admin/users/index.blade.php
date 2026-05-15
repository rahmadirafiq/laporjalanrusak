@extends('admin.layouts.app')
@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')
<div class="filter-bar mb-4">
  <form method="GET" action="{{ route('admin.users.index') }}">
    <div class="row g-3 align-items-end">
      <div class="col-md-6">
        <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, nomor HP..."/>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100" style="border-radius:10px;font-size:.85rem;font-weight:600;">
          <i class="bi bi-search me-1"></i>Cari
        </button>
      </div>
      <div class="col-md-2">
        <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100" style="border-radius:10px;font-size:.85rem;">Reset</a>
      </div>
    </div>
  </form>
</div>

<div class="data-table">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>#</th><th>Nama</th><th>Email</th><th>Telepon</th>
          <th>Kelurahan</th><th>Jumlah Laporan</th><th>Bergabung</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td style="color:var(--text-muted);font-size:.8rem;">{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:34px;height:34px;border-radius:50%;background:var(--light-bg);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;color:var(--primary);flex-shrink:0;">
                {{ strtoupper(substr($user->name,0,2)) }}
              </div>
              <span style="font-weight:600;font-size:.85rem;">{{ $user->name }}</span>
            </div>
          </td>
          <td style="font-size:.83rem;">{{ $user->email }}</td>
          <td style="font-size:.83rem;">{{ $user->phone ?? '-' }}</td>
          <td style="font-size:.83rem;">{{ $user->kelurahan ?? '-' }}</td>
          <td>
            <span style="background:var(--light-bg);padding:3px 10px;border-radius:20px;font-weight:700;font-size:.8rem;color:var(--primary);">
              {{ $user->laporans_count }} laporan
            </span>
          </td>
          <td style="font-size:.8rem;color:var(--text-muted);">{{ $user->created_at->format('d M Y') }}</td>
          <td>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun {{ $user->name }}?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;font-size:.75rem;">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" class="text-center py-4" style="color:var(--text-muted);">Tidak ada pengguna ditemukan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="p-3">
    {{ $users->withQueryString()->links() }}
  </div>
</div>
@endsection