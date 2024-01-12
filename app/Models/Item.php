<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use HasFactory, HasUuids, Searchable;

    protected $touches = ['auctions'];//Algolia

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'items';

    protected $fillable = [
        'title', 
        'description',
        'condition_id',
        'category_id',
        'price',
        'quantity',
        'quantity_sold',
    ];

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $array['condition'] = $this->condition->condition;

        return $array;
    }

    public function auctions(): BelongsTo
    {
        return $this->belongsTo(Auction::class, 'auction_uuid');
    }

    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class, 'condition_id');
    }

    public function canLowerPrice(): bool
    {
        $auction = Auction::find($this->auction_uuid);
        return (
           (!$auction->is_blocked) && ($this->quantity_sold == 0)
        );
    }
}
