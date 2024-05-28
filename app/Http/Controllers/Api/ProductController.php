<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    private $status = 200;
    
    public function getAllProduct(){
        $products = Product::select('name', 'slug', 'image')->where('status', 1)->orderBy('created_at')->get();
        return response()->json($products, $this->status, [], JSON_UNESCAPED_UNICODE);
    }
}
