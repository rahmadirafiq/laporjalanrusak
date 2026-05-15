<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder {
    public function run(): void {
        Admin::create([
            'name'     => 'Super Admin',
            'email'    => 'admin@laporjalanrusak.id',
            'password' => Hash::make('admin123'),
            'role'     => 'superadmin',
        ]);

        Admin::create([
            'name'     => 'Petugas Dinas PU',
            'email'    => 'petugas@laporjalanrusak.id',
            'password' => Hash::make('petugas123'),
            'role'     => 'admin',
        ]);
    }
}