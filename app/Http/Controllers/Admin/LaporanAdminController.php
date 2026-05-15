<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanAdminController extends Controller {

    public function index(Request $request) {
        $query = Laporan::with('user');

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->tingkat) {
            $query->where('tingkat_kerusakan', $request->tingkat);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode', 'like', '%' . $request->search . '%')
                  ->orWhere('lokasi_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_pelapor', 'like', '%' . $request->search . '%')
                  ->orWhere('jenis_kerusakan', 'like', '%' . $request->search . '%');
            });
        }

        $laporans = $query->latest()->paginate(15);

        $stats = [
            'total'    => Laporan::count(),
            'menunggu' => Laporan::where('status', 'menunggu')->count(),
            'proses'   => Laporan::where('status', 'proses')->count(),
            'selesai'  => Laporan::where('status', 'selesai')->count(),
        ];

        return view('admin.laporan.index', compact('laporans', 'stats'));
    }

    public function detail($id) {
        $laporan = Laporan::with('user')->findOrFail($id);
        return view('admin.laporan.detail', compact('laporan'));
    }

    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status'        => 'required|in:menunggu,diverifikasi,proses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Status laporan ' . $laporan->kode . ' berhasil diperbarui menjadi "' . $laporan->label_status . '".');
    }

    public function destroy($id) {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->foto) {
            foreach ($laporan->foto as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function export(Request $request) {
        $query = Laporan::with('user');

        if ($request->status) $query->where('status', $request->status);
        if ($request->tingkat) $query->where('tingkat_kerusakan', $request->tingkat);

        $laporans = $query->latest()->get();

        $filename = 'laporan-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($laporans) {
            $file = fopen('php://output', 'w');

            // Header CSV
            fputcsv($file, [
                'Kode', 'Nama Pelapor', 'Telepon', 'Jenis Kerusakan',
                'Tingkat', 'Lokasi', 'Kelurahan', 'Kecamatan',
                'Status', 'Tanggal Lapor', 'Catatan Admin'
            ]);

            foreach ($laporans as $lap) {
                fputcsv($file, [
                    $lap->kode,
                    $lap->nama_pelapor,
                    $lap->telepon_pelapor,
                    $lap->jenis_kerusakan,
                    $lap->tingkat_kerusakan,
                    $lap->lokasi_lengkap,
                    $lap->kelurahan,
                    $lap->kecamatan,
                    $lap->label_status,
                    $lap->created_at->format('d/m/Y H:i'),
                    $lap->catatan_admin,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}