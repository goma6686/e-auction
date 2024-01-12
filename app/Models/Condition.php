<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Condition extends Model
{
    use HasFactory, Searchable;

    public $timestamps = false;

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }
}
