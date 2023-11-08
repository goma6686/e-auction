<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Condition extends Model
{
    use HasFactory;

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}
