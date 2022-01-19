<?php


namespace App;

use System\Database\ORM\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title', 'body', 'cat_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }
}