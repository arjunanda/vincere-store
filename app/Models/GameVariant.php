<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameVariant extends Model
{
    protected $fillable = ['game_id', 'name', 'quantity', 'price', 'original_price', 'provider_id', 'is_active'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
