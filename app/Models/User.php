<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $kelurahan
 * @property bool $notif_email
 * @property bool $notif_whatsapp
 * @method HasMany laporans()
 * @method bool update(array $attributes = [])
 */
class User extends Authenticatable {
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'kelurahan', 'password',
        'notif_email', 'notif_whatsapp',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
        'notif_email' => 'boolean',
        'notif_whatsapp' => 'boolean',
    ];

    public function laporans() {
        return $this->hasMany(Laporan::class);
    }
}