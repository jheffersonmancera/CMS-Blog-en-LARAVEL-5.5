<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	
	
	protected $fillable = [//*4Post:
		'user_id', 'category_id', 'name', 'slug', 'excerpt', 'body', 'status', 'file',
	];


	public function user(){
    	return $this->belongsTo(User::class);//un Post pertenece a un User
    	
    }
    
    public function category(){//*3Post.php
    	return $this->belongsTo(Category::class);////Un Post pertence a una Category
    	
    }
    public function tags(){//*2Post.php
    	return $this->belongsToMany(Tag::class);//*1Post.php
    }
}
