<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

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
        'tracking_number',
        'hp',
        'alamat',
        'pos',
        'foto_resi' // foto resi lupa, mau tambhakan kemarin.
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d M Y H:i');
    }

    public function getStatusBadgeAttribute()
    {
        $status = strtolower($this->status);
        $class = 'secondary';

        if ($status === 'completed' || $status === 'sukses') {
            $class = 'success';
        } elseif ($status === 'pending') {
            $class = 'warning';
        } elseif ($status === 'cancelled') {
            $class = 'danger';
        } elseif ($status === 'processing') {
            $class = 'info';
        }

        return '<span class="badge bg-'.$class.'">'.ucfirst($status).'</span>';
    }
}
