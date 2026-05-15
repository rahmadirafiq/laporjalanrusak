<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfilController extends Controller {

    public function index() {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $stats = [
            'total'   => $user->laporans()->count(),
            'selesai' => $user->laporans()->where('status', 'selesai')->count(),
            'proses'  => $user->laporans()->where('status', 'proses')->count(),
        ];
        return view('profil.index', compact('user', 'stats'));
    }

    public function update(Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'nullable|string|max:20',
            'kelurahan' => 'nullable|string',
            'email'     => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'phone', 'kelurahan', 'email'));

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diubah!');
    }

    public function updateNotifikasi(Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'notif_email'     => $request->boolean('notif_email'),
            'notif_whatsapp'  => $request->boolean('notif_whatsapp'),
        ]);

        return back()->with('success', 'Pengaturan notifikasi disimpan!');
    }
}