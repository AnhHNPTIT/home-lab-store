<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	protected $fillable = ['name', 'slug'];

	public function posts(){
		return $this->belongsToMany('App\Models\Post');
	}

	public function post_tags(){
		return $this->hasMany('App\Models\PostTags');
	}
}