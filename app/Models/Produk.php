<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'produk'; // Pastikan sesuai dengan nama tabel di database

    // Menentukan kolom yang bisa diisi massal
    protected $fillable = [
        'kategori_id',
        'user_id',
        'status',
        'nama_produk',  // Sesuaikan dengan kolom di database
        'detail',       // Sebelumnya 'deskripsi'
        'harga',
        'stok',
        'berat',
        'foto'          // Sebelumnya 'gambar'
    ];

    /**
     * Relasi ke Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // Menentukan foreign key jika diperlukan
    }

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Menentukan foreign key jika diperlukan
    }

    /**
     * Relasi produk ke order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'produk_id'); // Pastikan foreign key sesuai
    }

    /**
     * Accessor untuk format harga
     */
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Scope untuk produk aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 1);
    }
}
