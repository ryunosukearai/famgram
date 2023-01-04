<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed(); //owner of the post
    }

    public function categoryPost()
    {
        return $this->hasMany(CategoryPost::class)->withTrashed();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest(); //latest入れると最新順になる
    }

    public function likes()
    {
        return $this->hasMany(Like::class); //select * from likes where post_id = ???(posts_table id?)
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists(); //select * from likes where user_id = ???(users_table id) //true or false
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

}
