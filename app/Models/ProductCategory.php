<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
	protected $fillable  = [
		'name', 'slug'
	];

	public function products(){
		return $this->hasMany('App\Models\Product');
	}

	public function countProduct(){
		return $this->hasMany('App\Models\Product', 'product_category_id')->get()->count();
	}
}
