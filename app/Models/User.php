<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function routeNotificationForMail(): array
    {
        return [$this->email => $this->username];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_uuid');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class, 'user_uuid');
    }

    public function favourites(): HasMany
    {
        return $this->hasMany(Favourite::class, 'user_uuid');
    }

    public function winningAuctions(): BelongsToMany
    {
        return $this->BelongsToMany(Auction::class, 'winners' ,'user_uuid');
    }

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class, 'conversation_user', 'user_uuid', 'auction_uuid')
            ->withPivot(['user_uuid', 'auction_uuid']);
            /*return $this->belongsToMany(Conversation::class, 'conversation_user', 'user_uuid', 'conversation_id')
            ->withPivot(['user_uuid', 'conversation_id']);*/
    }

    public function getSecondChanceAuctions(): array
    {
        return Auction::where('user_uuid', $this->uuid)
        ->withCount(['bids'])
        ->where('type_id', '=', '2')
        ->where('is_blocked', false)
        ->where('is_active', false)
        ->where('end_time', '<', now())
        ->where('reserve_price', '>', 'price')
        ->whereNotIn('uuid', Winner::select('auction_uuid')->get()->pluck('auction_uuid')->toArray())
        ->whereHas('bids')
        ->pluck('uuid')->toArray();
    }

    public function getAuctionsEndedWithNoBids(): array {
        return Auction::where('user_uuid', $this->uuid)
            ->withCount(['bids'])
            ->where('type_id', '=', '2')
            ->where('is_blocked', false)
            ->where('is_active', false)
            ->where('end_time', '<', now())
            ->whereDoesntHave('bids')
            ->pluck('uuid')->toArray();
    }

    public function getFavouriteAuctions(): array {
        return Auction::whereIn('uuid', 
            $this->favourites->pluck('auction_uuid')->toArray())
                ->withCount(['bids'])
                ->where('is_blocked', false)
                ->where('is_active', true)
                ->where('end_time', '>', now())
                ->with(['items', 'category', 'items.condition', 'type'])
                ->withMin('items', 'price')
                ->get()
                ->toArray();
    }

    public function getActiveBids(): array {
        return Auction::withCount(['bids', 'items'])
            ->whereIn('uuid', $this->bids->pluck('auction_uuid')->toArray())
            ->where('is_active', true)
            ->where('end_time', '>', now())
            ->with(['items', 'category', 'items.condition'])
            ->addSelect(['highest_bidder' => 
                Bid::select('user_uuid')->whereColumn('auction_uuid', 'auctions.uuid')->orderByDesc('amount')->limit(1)])
            ->get()
            ->toArray();
    }

    public function AllUserAuctions() {
        return Auction::where('user_uuid', $this->uuid)
            ->withCount(['bids', 'items'])
            ->with(['items', 'category', 'items.condition', 'type'])
            ->withMin('items', 'price')
            ->get();
    }

    public function ActiveUserAuctions() {
        return Auction::where('user_uuid', $this->uuid)
            ->withCount(['bids', 'items'])
            ->where('is_active', true)
            ->where('is_blocked', false)
            ->with(['items', 'category', 'items.condition', 'type'])
            ->withMin('items', 'price')
            ->get();
    }

    public function getWonAuctions() {
        return Auction::withCount(['bids', 'items'])
            ->whereIn('uuid', 
                Winner::where('user_uuid', $this->uuid)->pluck('auction_uuid')->toArray())
            ->with(['items', 'category', 'items.condition'])
            ->orderByDesc('bids_count')
            ->get();
    }

    public function getWaitingForPaymentAuctions(){
        return Auction::withCount(['bids', 'items'])
            ->whereIn('uuid', Winner::whereIn('auction_uuid', $this->auctions->pluck('uuid')->toArray())
                ->pluck('auction_uuid')->toArray())
            ->with(['items', 'category', 'items.condition'])
            ->orderByDesc('bids_count')
            ->get();
    }

    public function getActionRequiredAuctions(): array {
        return Auction::where('user_uuid', $this->uuid)
            ->withCount(['bids', 'items'])
            ->whereIn('uuid', $this->getSecondChanceAuctions())
            ->with(['items', 'category', 'items.condition'])
            ->union(
                Auction::where('user_uuid', $this->uuid) // auctions that have ended without bids
                ->withCount(['bids', 'items'])
                ->whereIn('uuid', $this->getAuctionsEndedWithNoBids())
                ->whereDoesntHave('bids')
                ->with(['items', 'category', 'items.condition'])
            )
            ->get()
            ->toArray();
    }
    
}
