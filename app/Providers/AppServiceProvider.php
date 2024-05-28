<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Manufacture;
use App\Models\Unit;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!\App::runningInConsole()) {
            // chu de
            View::share('categories', PostCategory::orderBy('sort_id', 'asc')->get());

            // the bai viet
            View::share('tags', Tag::all());

            // bai viet
            View::share('new_posts', Post::orderBy('created_at', 'desc')->take(12)->get());

            // nhom san pham
            View::share('product_categories', ProductCategory::orderBy('name', 'asc')->get());

            // san pham moi
            View::share('new_products', Product::orderBy('created_at', 'desc')->take(10)->get());

            // nha san xuat
            View::share('manufacturers', Manufacture::orderBy('name', 'asc')->get());

            //don vi tinh
            View::share('units', Unit::orderBy('name', 'asc')->get());

            // vitamin product order by created at desc
            View::share('new_vitamin_products', Product::where('product_category_id', 1)->where('status', 1)->orderBy('created_at', 'desc')->take(6)->get());
            // menu vitamin product order by price sale desc
            View::share('menu_vitamin_products', Product::where('product_category_id', 1)->where('status', 1)->orderBy('price_sale', 'desc')->take(15)->get());
            // menu vitamin product order by price sale asc
            View::share('menu_vitamin_products_asc', Product::where('product_category_id', 1)->where('status', 1)->orderBy('price_sale', 'asc')->take(15)->get());
            // vitamin product co gia ban nho nhat
            View::share('price_sale_min_vitamin_product', Product::where('product_category_id', 1)->where('status', 1)->min('price_sale'));
            // vitamin product co gia ban lon nhat
            View::share('price_sale_max_vitamin_product', Product::where('product_category_id', 1)->where('status', 1)->max('price_sale'));

            // energy product order by created at desc
            View::share('new_energy_products', Product::where('product_category_id', 2)->where('status', 1)->orderBy('created_at', 'desc')->take(6)->get());
            // menu energy product order by price sale desc
            View::share('menu_energy_products', Product::where('product_category_id', 2)->where('status', 1)->orderBy('price_sale', 'desc')->take(15)->get());
            // menu energy product order by price sale asc
            View::share('menu_energy_products_asc', Product::where('product_category_id', 2)->where('status', 1)->orderBy('price_sale', 'asc')->take(15)->get());
            // vitamin product co gia ban nho nhat
            View::share('price_sale_min_energy_product', Product::where('product_category_id', 2)->where('status', 1)->min('price_sale'));
            // vitamin product co gia ban lon nhat
            View::share('price_sale_max_energy_product', Product::where('product_category_id', 2)->where('status', 1)->max('price_sale'));

            // fiber product order by created at desc
            View::share('new_fiber_products', Product::where('product_category_id', 3)->where('status', 1)->orderBy('created_at', 'desc')->take(6)->get());
            // menu fiber product order by price sale desc
            View::share('menu_fiber_products', Product::where('product_category_id', 3)->where('status', 1)->orderBy('price_sale', 'desc')->take(15)->get());
            // menu fiber product order by price sale asc
            View::share('menu_fiber_products_asc', Product::where('product_category_id', 3)->where('status', 1)->orderBy('price_sale', 'asc')->take(15)->get());
            // vitamin product co gia ban nho nhat
            View::share('price_sale_min_fiber_product', Product::where('product_category_id', 3)->where('status', 1)->min('price_sale'));
            // vitamin product co gia ban lon nhat
            View::share('price_sale_max_fiber_product', Product::where('product_category_id', 3)->where('status', 1)->max('price_sale'));

            // special product order by created at desc
            View::share('new_special_products', Product::where('product_category_id', 4)->where('status', 1)->orderBy('created_at', 'desc')->take(6)->get());
            // menu special product order by price sale desc
            View::share('menu_special_products', Product::where('product_category_id', 4)->where('status', 1)->orderBy('price_sale', 'desc')->take(15)->get());
            // menu special product order by price sale asc
            View::share('menu_special_products_asc', Product::where('product_category_id', 4)->where('status', 1)->orderBy('price_sale', 'asc')->take(15)->get());
            // vitamin product co gia ban nho nhat
            View::share('price_sale_min_special_product', Product::where('product_category_id', 4)->where('status', 1)->min('price_sale'));
            // vitamin product co gia ban lon nhat
            View::share('price_sale_max_special_product', Product::where('product_category_id', 4)->where('status', 1)->max('price_sale'));

            // bai viet moi nhat
            View::share('recent_posts', Post::orderBy('created_at', 'desc')->take(5)->get());

            // san pham duoc quan tam nhieu nhat
            View::share('most_interesting_products', Product::where('status', 1)->orderBy('view_count', 'desc')->take(12)->get());

            // san pham ban nhieu nhat
            View::share('most_sold_products', Product::where('status', 1)->orderBy('bought', 'desc')->take(12)->get());
        }
    }
}
