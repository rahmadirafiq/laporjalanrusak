<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

    public function showLogin() {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard() {
        $stats = [
            'total'        => Laporan::count(),
            'menunggu'     => Laporan::where('status', 'menunggu')->count(),
            'diverifikasi' => Laporan::where('status', 'diverifikasi')->count(),
            'proses'       => Laporan::where('status', 'proses')->count(),
            'selesai'      => Laporan::where('status', 'selesai')->count(),
            'ditolak'      => Laporan::where('status', 'ditolak')->count(),
            'users'        => User::count(),
        ];

        $laporanTerbaru = Laporan::with('user')->latest()->take(8)->get();

        $perBulan = Laporan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $perBulan[$i]->total ?? 0;
        }

        return view('admin.dashboard', compact('stats', 'laporanTerbaru', 'chartData'));
    }
}