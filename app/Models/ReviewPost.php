<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ReviewPost extends Model
{
    use HasFactory, Sluggable;
    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['category'] ?? false, function($query, $category) {
                return $query->whereHas('category', function($query) use ($category) {
                    $query->where('slug', $category);
                });
        });
        
        $query->when($filters['user'] ?? false, fn($query, $user) =>
            $query->whereHas('user', fn($query) =>
                $query->where('username', $user)
            )
        );
    }

    protected $guarded = ['id'];
    protected $with = ['user', 'category']; // setiap pemanggilan post, user dan category di bawa
 
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ReviewComments()
    {   
        return $this->hasMany(ReviewComment::class);
    }

    public function ReviewLikes()
    {   
        return $this->hasMany(ReviewLike::class);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}