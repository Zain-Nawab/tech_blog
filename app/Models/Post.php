<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    protected $fillable = ['title', 'content', 'excerpt', 'photo_path', 'user_id', 'category-id'];

    // One to one relation 
    public function user(){
       return $this->belongsTo(User::class);
    }
}
