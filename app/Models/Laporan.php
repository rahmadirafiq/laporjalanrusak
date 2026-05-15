<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model {
    protected $fillable = [
        'kode', 'user_id', 'nama_pelapor', 'telepon_pelapor',
        'jenis_kerusakan', 'tingkat_kerusakan', 'lokasi_lengkap',
        'kelurahan', 'kecamatan', 'latitude', 'longitude',
        'deskripsi', 'foto', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'foto' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function generateKode(): string {
        $tahun = date('Y');
        $last = static::whereYear('created_at', $tahun)->count() + 1;
        return 'RPT-' . $tahun . '-' . str_pad($last, 4, '0', STR_PAD_LEFT);
    }

    public function getLabelStatusAttribute(): string {
        return match($this->status) {
            'menunggu'    => 'Menunggu Verifikasi',
            'diverifikasi'=> 'Telah Diverifikasi',
            'proses'      => 'Dalam Proses Perbaikan',
            'selesai'     => 'Selesai',
            'ditolak'     => 'Ditolak',
            default       => ucfirst($this->status),
        };
    }

    public function getBadgeClassAttribute(): string {
        return match($this->status) {
            'menunggu'    => 'badge-menunggu',
            'diverifikasi'=> 'badge-verifikasi',
            'proses'      => 'badge-proses',
            'selesai'     => 'badge-selesai',
            'ditolak'     => 'badge-ditolak',
            default       => '',
        };
    }
}