<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable  = [
        'order_id', 'product_id', 'name', 'slug', 'code',
        'quantity', 'sale', 'price', 'price_sale', 'status'
    ];
}
