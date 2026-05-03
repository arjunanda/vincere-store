<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InputField extends Model
{
    protected $fillable = ['input_group_id', 'label', 'name', 'placeholder', 'type', 'max_length'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(InputGroup::class, 'input_group_id');
    }
}
