<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected static function booted()
    {
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('web_settings');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('web_settings');
        });
    }
}
