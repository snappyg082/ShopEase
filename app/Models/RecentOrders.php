<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentOrders extends Model
{
    protected $table = 'recent_orders';

    protected $fillable = [
        'user_id',
        'order_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
