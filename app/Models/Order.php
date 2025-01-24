<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'notes',
        'ordered_at',
        'payment_method',
        'payment_status',
        'payment_due_at',
        'courier_id',
        'order_payment_id',
    ];

    protected $casts = [
        'ordered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function orderPayment()
    {
        return $this->belongsTo(OrderPayment::class);
    }
}
