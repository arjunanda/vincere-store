<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'category_id', 
        'input_group_id', 
        'name', 
        'slug', 
        'image', 
        'banner_image', 
        'platform_type', 
        'description', 
        'is_active'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function inputGroup(): BelongsTo
    {
        return $this->belongsTo(InputGroup::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(GameVariant::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
