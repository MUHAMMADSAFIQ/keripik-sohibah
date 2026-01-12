<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'address', 'phone', 'delivery_method', 
        'distance_meters', 'shipping_cost', 'total_price', 'status', 
        'latitude', 'longitude', 'payment_method', 'payment_status', 
        'sender_name', 'payment_proof', 'snap_token', 'transaction_id', 'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
