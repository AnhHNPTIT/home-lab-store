<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
	protected $fillable = ['id', 'title', 'thumbnail', 'description', 'content', 'slug', 'admin_name', 'post_category_id', 'view_count'];

	public function categories(){
		return $this->belongsTo('App\Category', 'post_category_id');
	}

	public function tags(){
		return $this->belongsToMany('App\Models\Tag');
	}

	public function post_tags(){
		return $this->hasMany('App\Models\PostTags');
	}
}
