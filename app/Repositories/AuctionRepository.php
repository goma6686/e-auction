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
        ->where('is_blocked', false)
        ->where('is_active', false)
        ->where('end_time', '<', now())
        ->where('reserve_price', '>', 'price')
        ->whereNotIn('uuid', Winner::select('auction_uuid')->get()->pluck('auction_uuid')->toArray())
        ->whereHas('bids')
        ->pluck('uuid')->toArray();
    }
}