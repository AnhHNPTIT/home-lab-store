<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
	protected $fillable = ['post_id', 'tag_id'];
	protected $table = "post_tags";

	public function tags(){
		return $this->belongsTo('App\Models\Tag', 'id');
	}

	public function posts(){
		return $this->belongsTo('App\Models\Post', 'id');
	}
}
