<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Auction extends Model
{
    use HasFactory, HasUuids, Searchable;
    
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'end_time' => 'datetime'
    ];

    protected $fillable = [
        'title', 
        'description',
        'category_id',
        'user_uuid',
        'type_id',
        'is_active',
        'end_time',
        'buy_now_price',
        'price',
        'reserve_price',
    ];

    public function searchableAs(): string
    {
        return config('scout.prefix') . 'auctions_index';
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $array['category'] = $this->category->name;
        $array['condition'] = $this->condition->name;
        $array['type'] = $this->type->name;
        $array['user'] = $this->user->name;

        return $array;
    }

    public function favourites(): HasMany
    {
        return $this->hasMany(Favourite::class, 'auction_uuid');
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'auction_uuid');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function getMaxBidAttribute()
    {
        return $this->bids()->max('amount') ?? $this->price;
    }

    public function getBidIncrements($max_bid = null)
    {
        $max_bid ?? $this->getMaxBidAttribute();
        return Bid::incremets()->collect()->filter(function ($increment) use ($max_bid) {
            return $max_bid >= $increment['from'] && $max_bid <= $increment['to'];
        })->first();
    }

    public function getBids(){
        $bids = Bid::where('auction_uuid', $this->uuid)->orderBy('amount', 'desc')->take(3)->get();
        $max_bid = $this->getMaxBidAttribute();
        $increment = $this->getBidIncrements($max_bid);
        for($i = 0; $i < 3; $i++){
            $bids[$i] = $max_bid + ($i+1)*$increment['increment'];
        }

        return $bids->toArray();
    }

    public function getIsAcceptingBidsAttribute()
    {
        $now = new \DateTime(\Carbon\Carbon::now());
        $end = new \DateTime($this->end_time);
        return $now < $end && $this->is_active;
    }
}
