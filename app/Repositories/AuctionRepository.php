<?php

namespace App\Repositories;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Winner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\AuctionRepositoryInterface;

class AuctionRepository implements AuctionRepositoryInterface {

    public function createWinner($auction){
        $winner = new Winner();
        $winner->user_uuid = Bid::select('user_uuid')
            ->where('auction_uuid', $auction->uuid)
            ->where('amount', $auction->bids()->max('amount'))->pluck('user_uuid')->first();
        $winner->auction_uuid = $auction->uuid;
        $winner->final_amount = $auction->bids()->max('amount');
        $winner->created_at = now();
        $winner->save();
    }
    
    public function getAuctionsEndedWithNoBids(): array {
        return Auction::where('user_uuid', Auth::user()->uuid)
            ->withCount(['bids'])
            ->where('type_id', '=', '2')
            ->where('is_blocked', false)
            ->where('is_active', false)
            ->where('end_time', '<', now())
            ->whereDoesntHave('bids')
            ->pluck('uuid')->toArray();
    }

    public function getSecondChanceAuctions(): array
    {
        return Auction::where('user_uuid', Auth::user()->uuid)
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

    public function getFavouriteAuctions(): array {
        return Auction::whereIn('uuid', 
            Auth::user()->favourites->pluck('auction_uuid')->toArray())
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
            ->whereIn('uuid', Auth::user()->bids->pluck('auction_uuid')->toArray())
            ->where('is_active', true)
            ->where('end_time', '>', now())
            ->with(['items', 'category', 'items.condition'])
            ->addSelect(['highest_bidder' => 
                Bid::select('user_uuid')->whereColumn('auction_uuid', 'auctions.uuid')->orderByDesc('amount')->limit(1)])
            ->get()
            ->toArray();
    }

    public function AllUserAuctions(): array {
        return Auction::where('user_uuid', Auth::user()->uuid)
            ->withCount(['bids', 'items'])
            ->with(['items', 'category', 'items.condition', 'type'])
            ->withMin('items', 'price')
            ->get()
            ->toArray();
    }

    public function getWonAuctions(): array {
        return Auction::withCount(['bids', 'items'])
            ->whereIn('uuid', 
                Winner::where('user_uuid', Auth::user()->uuid)->pluck('auction_uuid')->toArray())
            ->with(['items', 'category', 'items.condition'])
            ->orderByDesc('bids_count')
            ->get()
            ->toArray();
    }

    public function getWaitingForPaymentAuctions(): array {
        return Auction::withCount(['bids', 'items'])
            ->whereIn('uuid', Winner::whereIn('auction_uuid', Auth::user()->auctions->pluck('uuid')->toArray())
                ->pluck('auction_uuid')->toArray())
            ->with(['items', 'category', 'items.condition'])
            ->orderByDesc('bids_count')
            ->get()
            ->toArray();
    }

    public function getActionRequiredAuctions(): array {
        return Auction::where('user_uuid', Auth::user()->uuid)
            ->withCount(['bids', 'items'])
            ->whereIn('uuid', $this->getSecondChanceAuctions())
            ->with(['items', 'category', 'items.condition'])
            ->union(
                Auction::where('user_uuid', Auth::user()->uuid) // auctions that have ended without bids
                ->withCount(['bids', 'items'])
                ->whereIn('uuid', $this->getAuctionsEndedWithNoBids())
                ->whereDoesntHave('bids')
                ->with(['items', 'category', 'items.condition'])
            )
            ->get()
            ->toArray();
    }
}