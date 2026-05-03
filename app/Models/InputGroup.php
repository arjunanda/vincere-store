<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InputGroup extends Model
{
    protected $fillable = ['name'];

    public function fields(): HasMany
    {
        return $this->hasMany(InputField::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
