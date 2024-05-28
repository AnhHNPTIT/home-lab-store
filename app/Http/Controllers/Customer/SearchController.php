<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SearchController extends Controller
{
    public function search(Request $request){
        $parameter = trim($request->parameter);
        $products = Product::where('name', 'like', "%$parameter%")->where('status', 1)->where('quantity', '>', 0)->orderBy('name', 'asc')->paginate(15);
        return view('search', ['parameter' => $parameter, 'products' => $products]);
    }
}
