<?php

namespace App\Models;

use App\Http\Controllers\ProfileController;
use Carbon\Carbon;
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
        'is_blocked',
        'end_time',
        'buy_now_price',
        'price',
        'reserve_price',
    ];

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $array['category'] = $this->category->category;
        $array['type'] = $this->type->type;
        $array['user'] = $this->user->username;
        $array['images'] = $this->items->pluck('image')->toArray();
        $array['items_min_price'] = $this->items->min('price');
        $array['items_max_price'] = $this->items->max('price');
        $array['bids_count'] = $this->bids->count();

        return $array;
    }

    public function shouldBeSearchable()
    {
        return $this->is_active && !$this->is_blocked;
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

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_uuid');
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

    public function winner(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_uuid');
    }

    public function getMaxBidAttribute()
    {
        return $this->bids()->max('amount') ?? $this->price;
    }

    public function getMinPriceAttribute()
    {
        return $this->items()->min('price');
    }

    public function getMaxPriceAttribute()
    {
        return $this->items()->max('price');
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

    public function getIsAcceptingBidsAttribute(): bool
    {
        $now = new \DateTime(\Carbon\Carbon::now());
        $end = new \DateTime($this->end_time);
        return $now < $end && $this->is_active;
    }

    public function canExtendTime(): bool
    {
        return (
            (!$this->is_blocked) &&
            Carbon::now()->subHours(2)->lte($this->created_at) &&
            ($this->bids()->count() == 0)
        );
    }

    public function canLowerPrice(): bool
    {
        return (
            (!$this->is_blocked) && 
            ((new \DateTime($this->end_time))->diff(new \DateTime(Carbon::now()))->h < 12)
            &&
            ($this->bids()->count() == 0)
        );
    }

    public function secondChance(): bool
    {
        $controller = new ProfileController();
        $auctions = $controller->getSecondChanceAuctions();

        return in_array($this->uuid, $auctions);
    }

    public function endedWithNoBids(): bool
    {
        $controller = new ProfileController();
        $array= $controller->getAuctionsEndedWithNoBids();
        return in_array($this->uuid, $array);
    }

    public function getAuctionSeller(): User
    {
        return User::find($this->user_uuid);
    }

    public function getAuctionWinner(): User | null
    {
       return  User::find(Winner::where('auction_uuid', $this->uuid)->pluck('user_uuid')->first());
    }
}
