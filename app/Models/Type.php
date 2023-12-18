<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Type extends Model
{
    use HasFactory, Searchable;

    public function auctions(): BelongsToMany
    {
        return $this->belongsToMany(Auction::class, 'auction_type', 'type_id', 'auction_uuid');
    }
}
