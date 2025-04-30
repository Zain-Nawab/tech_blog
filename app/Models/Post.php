<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    protected $fillable = ['title', 'content', 'excerpt', 'photo_path', 'user_id', 'category_id'];

    // One to one relation 
    public function user(){
       return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }


                public function likes()
            {
                return $this->hasMany(Like::class);
            }

            public function isLikedBy(User $user)
            {
                return $this->likes()->where('user_id', $user->id)->exists();
            }

}
