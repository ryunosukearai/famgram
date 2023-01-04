<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_post'; //connect this model to category_post table
    public $timestamps = false;
    protected $fillable = ['category_id', 'post_id']; //allow mass assignment

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
