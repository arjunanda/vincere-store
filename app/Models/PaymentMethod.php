<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentMethod extends Model
{
    protected $fillable = [
        'type',
        'name',
        'code',
        'account_number',
        'account_name',
        'image',
        'qris_image',
        'fee',
        'is_active'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('active_payment_methods');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('active_payment_methods');
        });
    }
}
