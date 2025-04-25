<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customers';  // Pastikan nama tabel sesuai dengan tabel yang Anda miliki

    protected $fillable = [
        'user_id', 'google_id', 'google_token', 'hp', 'alamat', 'pos', 'foto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($customer) {
            // Hapus user yang terkait ketika customer dihapus
            if ($customer->user) {
                $customer->user->delete();
            }
        });
    }

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
