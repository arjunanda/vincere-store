<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'game_id',
        'game_name',
        'variant_id',
        'variant_name',
        'input_data',
        'total_price',
        'payment_method',
        'payment_status',
        'delivery_status',
        'proof_of_payment',
        'notes'
    ];

    protected $casts = [
        'input_data' => 'array',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(GameVariant::class, 'variant_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
