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
            View::share('new_products', Product::where('status', 1)->orderBy('created_at', 'desc')->limit(15)->get());

            // nha san xuat
            View::share('manufacturers', Manufacture::orderBy('name', 'asc')->get());

            //don vi tinh
            View::share('units', Unit::orderBy('name', 'asc')->get());

            // bai viet moi nhat
            View::share('recent_posts', Post::orderBy('created_at', 'desc')->take(5)->get());

            // san pham duoc quan tam nhieu nhat
            View::share('most_interesting_products', Product::where('status', 1)->orderBy('view_count', 'desc')->take(12)->get());

            // san pham ban nhieu nhat
            View::share('most_sold_products', Product::where('status', 1)->orderBy('bought', 'desc')->take(12)->get());
        }
    }
}
