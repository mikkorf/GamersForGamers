<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reviewPosts()
    {
        return $this->hasMany(ReviewPost::class);
    }

    public function tipPosts()
    {
        return $this->hasMany(TipPost::class);
    }

    public function newsPosts()
    {
        return $this->hasMany(NewsPost::class);
    }
}