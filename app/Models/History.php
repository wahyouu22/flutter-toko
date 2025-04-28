<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'orders'; // Menggunakan tabel orders yang sama
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'total_price',
        'shipping_cost',
        'final_price',
        'shipping_service',
        'shipping_etd',
        'destination_city',
        'status',
        'resi',
        'address',
        'pos_code',
        'phone'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}
