<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }
}
