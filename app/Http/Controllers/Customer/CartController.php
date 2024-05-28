<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $data = [];
        if (Session::has('cart')) {
            $data = Session::get('cart');
        }
        return view('shopping_cart', compact('data'));
    }

    public function addSpecialItem(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }
        $cart = Session::get('cart');
        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "code" => $product->code,
                    "image" => $product->image,
                    "price" => $product->price,
                    "price_sale" => $product->price_sale,
                    "qty" => $qty,
                ]
            ];
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng thành công!');
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng thành công!');
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "slug" => $product->slug,
            "code" => $product->code,
            "image" => $product->image,
            "price" => $product->price,
            "price_sale" => $product->price_sale,
            "qty" => $qty,
        ];
        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng thành công!');
    }

    public function addItem(Request $request)
    {
        $id = $request->id;
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }
        $cart = Session::get('cart');
        // if cart is empty then this the first product
        if (!$cart) {
            $cart = [
                $id => [
                    "name" => $product->name,
                    "slug" => $product->slug,
                    "code" => $product->code,
                    "image" => $product->image,
                    "price" => $product->price,
                    "price_sale" => $product->price_sale,
                    "qty" => 1
                ]
            ];
            Session::put('cart', $cart);
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng thành công!');
        }

        // if cart not empty then check if this product exist then increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
            Session::put('cart', $cart);
        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "slug" => $product->slug,
            "code" => $product->code,
            "image" => $product->image,
            "price" => $product->price,
            "price_sale" => $product->price_sale,
            "qty" => 1
        ];
        Session::put('cart', $cart);
    }

    public function remove($id)
    {
        if ($id) {
            $cart = Session::get('cart');
            if (isset($cart[$id])) {
                unset($cart[$id]);
                Session::put('cart', $cart);
            }
        }
    }

    public function clearCart()
    {
        if (Session::has('cart')) {
            Session::forget('cart');
        }
    }

    public function increment(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $cart = Session::get('cart');
            if ($cart[$id]) {
                $cart[$id]['qty']++;
                Session::put('cart', $cart);
            }
        }
    }

    public function decrement(Request $request)
    {
        $id = $request->id;
        if ($id) {
            $cart = Session::get('cart');
            if ($cart[$id]) {
                if ($cart[$id]['qty'] == 1) {
                    unset($cart[$id]);
                    Session::put('cart', $cart);
                } else {
                    $cart[$id]['qty'] -= 1;
                    Session::put('cart', $cart);
                }
            }
        }
    }

    public function getItemNumber()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            return $cart->totalProduct;
        }
        return 0;
    }
}
