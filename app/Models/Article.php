<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'type', 'image', 'excerpt', 'content', 'is_active', 'published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
