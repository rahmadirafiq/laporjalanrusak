<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller {

    public function index(Request $request) {
        $query = User::withCount('laporans');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'Akun pengguna ' . $user->name . ' berhasil dihapus.');
    }
}