<?php

namespace App\Models;

// use Dom\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
