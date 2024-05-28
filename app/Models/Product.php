<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name', 'slug', 'code', 'product_category_id', 'manufacturer_id', 
        'description', 'active', 'frequence', 'packed', 'effect', 'maintain', 
        'object', 'image', 'price_prime', 'price', 'unit_id', 'price_sale', 
        'quantity', 'admin_id', 'bought', 'view_count', 'status'
    ];
}