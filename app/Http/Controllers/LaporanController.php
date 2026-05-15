<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller {

    public function form() {
        return view('laporan.form');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_pelapor'    => 'required|string|max:255',
            'telepon_pelapor' => 'nullable|string|max:20',
            'jenis_kerusakan' => 'required|string',
            'tingkat_kerusakan' => 'required|in:ringan,sedang,parah',
            'lokasi_lengkap'  => 'required|string',
            'kelurahan'       => 'required|string',
            'kecamatan'       => 'required|string',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'deskripsi'       => 'required|string|min:20',
            'foto.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Simpan foto
        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('laporan', 'public');
                $fotoPaths[] = $path;
            }
        }

        $laporan = Laporan::create([
            'kode'             => Laporan::generateKode(),
            'user_id'          => Auth::id(),
            'nama_pelapor'     => $request->nama_pelapor,
            'telepon_pelapor'  => $request->telepon_pelapor,
            'jenis_kerusakan'  => $request->jenis_kerusakan,
            'tingkat_kerusakan'=> $request->tingkat_kerusakan,
            'lokasi_lengkap'   => $request->lokasi_lengkap,
            'kelurahan'        => $request->kelurahan,
            'kecamatan'        => $request->kecamatan,
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'deskripsi'        => $request->deskripsi,
            'foto'             => $fotoPaths,
        ]);

        return redirect()->route('laporan.detail', $laporan->id)
                         ->with('success', 'Laporan berhasil dikirim! Kode laporan: ' . $laporan->kode);
    }

    public function riwayat(Request $request) {
        $query = Laporan::query();

        // Jika login, tampilkan milik user saja
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            // Tamu tidak punya riwayat — redirect ke login
            return redirect()->route('login')->with('success', 'Silakan login untuk melihat riwayat laporan.');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('kode', 'like', '%'.$request->search.'%')
                  ->orWhere('lokasi_lengkap', 'like', '%'.$request->search.'%')
                  ->orWhere('jenis_kerusakan', 'like', '%'.$request->search.'%');
            });
        }

        $laporans = $query->latest()->paginate(10);

        $userId = Auth::id();
        $stats = [
            'total'   => Laporan::where('user_id', $userId)->count(),
            'selesai' => Laporan::where('user_id', $userId)->where('status', 'selesai')->count(),
            'proses'  => Laporan::where('user_id', $userId)->where('status', 'proses')->count(),
        ];

        return view('laporan.riwayat', compact('laporans', 'stats'));
    }

    public function detail($id) {
        $laporan = Laporan::findOrFail($id);

        // Proteksi: hanya pemilik atau tamu
        if (Auth::check() && $laporan->user_id && $laporan->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak melihat laporan ini.');
        }

        return view('laporan.detail', compact('laporan'));
    }

    public function destroy($id) {
        $laporan = Laporan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Hapus foto
        if ($laporan->foto) {
            foreach ($laporan->foto as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $laporan->delete();

        return redirect()->route('laporan.riwayat')->with('success', 'Laporan berhasil dihapus.');
    }
}