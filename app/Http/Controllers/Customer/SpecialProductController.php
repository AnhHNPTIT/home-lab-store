<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Manufacture;

use Illuminate\Support\Facades\DB;

class SpecialProductController extends Controller
{
    public function index()
    {
        $products = Product::where('product_category_id', 4)->where('status', 1)->orderBy('price_sale')->paginate(20);
        return view('category_products', ['products' => $products, 'title' => 'Chức năng đặc biệt']);
    }

    public function specialProduct(Request $request)
    {
        $sortby = $request->sortby;
        $min_price = ((int) $request->min_price) / 1000;
        $max_price = ((int) $request->max_price) / 1000;
        if ($min_price && $max_price) {
            if ($sortby == 'price-desc')
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')
                    ->where('product_category_id', 4)
                    ->where('status', 1)
                    ->where('price_sale', '>=', $min_price)
                    ->where('price_sale', '<=', $max_price)
                    ->orderBy('price_sale', 'desc');
            else if ($sortby == 'name')
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')
                    ->where('product_category_id', 4)
                    ->where('status', 1)
                    ->where('price_sale', '>=', $min_price)
                    ->where('price_sale', '<=', $max_price)
                    ->orderBy('name');
            else if ($sortby == 'date')
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')
                    ->where('product_category_id', 4)
                    ->where('status', 1)
                    ->where('price_sale', '>=', $min_price)
                    ->where('price_sale', '<=', $max_price)
                    ->orderBy('created_at', 'desc');
            else
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')
                    ->where('product_category_id', 4)
                    ->where('status', 1)
                    ->where('price_sale', '>=', $min_price)
                    ->where('price_sale', '<=', $max_price)
                    ->orderBy('price_sale', 'asc');
        } else {
            if ($sortby == 'price-desc')
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')->where('product_category_id', 4)->where('status', 1)->orderBy('price_sale', 'desc');
            else if ($sortby == 'name')
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')->where('product_category_id', 4)->where('status', 1)->orderBy('name');
            else if ($sortby == 'date')
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')->where('product_category_id', 4)->where('status', 1)->orderBy('created_at', 'desc');
            else
                $products = Product::select('id', 'name', 'slug', 'image', 'price_sale', 'price', 'quantity')->where('product_category_id', 4)->where('status', 1)->orderBy('price_sale', 'asc');
        }

        // manufacture
        if ($request->brand) {
            $brands = explode(',', $request->brand);
        }
        $check_manufactures = [];
        if (isset($brands)) {
            $manufactures = [];
            
            for ($i = 0; $i < count($brands); $i++) {
                $manufacture = Manufacture::select('id')->where('slug', $brands[$i])->first();
                if ($manufacture) {
                    array_push($manufactures, $manufacture->id);
                }
            }

            for ($i = 0; $i < count($manufactures); $i++) {
                $check_manufactures[$manufactures[$i]] = true;
            }

            $products = $products->whereIn('manufacturer_id', $manufactures);
        }

        $products = $products->paginate(12);
        $title = "Chức năng đặc biệt";
        if ($sortby != null) {
            return view('category_products', compact('title', 'sortby', 'products', 'check_manufactures', 'min_price', 'max_price'));
        }
        return view('category_products', compact('title', 'products', 'check_manufactures', 'min_price', 'max_price'));
    }
}
