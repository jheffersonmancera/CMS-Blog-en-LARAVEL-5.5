<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	
	//guardar datos de forma masiva
	protected $fillable = [
		'user_id', 'category_id', 'name', 'slug', 'excerpt', 'body', 'status', 'file'
	];


	public function user(){
    	return $this->belongsTo(User::class);//un Post pertenece a un User
    	
    }
    
    public function category(){
    	return $this->belongsTo(Category::class);////Un Post pertence a una Category
    	
    }
    public function tags(){
    	return $this->belongsToMany(Tag::class);//belongs to many relacion de muchos a muchos//tiene y pertenece a muchas Tag
    	
    }
}
