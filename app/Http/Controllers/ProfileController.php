<?php

namespace App\Http\Controllers;

use App\Events\EndAuction;
use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Winner;
use App\Repositories\Interfaces\AuctionRepositoryInterface;

class ProfileController extends Controller
{
    public function getAuctionsEndedWithNoBids(): array {
        $auction_repository = app()->make(AuctionRepositoryInterface::class);
        return $auction_repository->getAuctionsEndedWithNoBids();
    }

    public function getSecondChanceAuctions(): array {
        $auction_repository = app()->make(AuctionRepositoryInterface::class);
        return $auction_repository->getSecondChanceAuctions();
    }

    public function profile(Request $request, $uuid) {
        $user = User::find($uuid);

        $active_auctions = $user->auctions()
                ->withCount(['bids', 'items'])
                ->where('is_active', true)
                ->with(['items', 'category', 'items.condition'])
                ->withMin('items', 'price')
                ->get();

        if(Auth::check() && Auth::user()->uuid == $uuid) {
            
            $all_auctions = $user->auctions()
                ->withCount(['bids', 'items'])
                ->with(['items', 'category', 'items.condition'])
                ->whereNotIn('uuid', Winner::whereIn('auction_uuid', $user->auctions()->pluck('uuid')->toArray())
                    ->pluck('auction_uuid')->toArray())
                ->withMin('items', 'price')
                ->get();

            $favourited = Auction::whereIn('uuid', 
                Auth::user()->favourites->pluck('auction_uuid')->toArray())
                ->withCount(['bids'])
                ->with(['items', 'category', 'items.condition', 'type'])
                ->withMin('items', 'price')
                ->get();

            $active_bids = Auction::withCount(['bids', 'items'])
                ->whereIn('uuid', Auth::user()->bids->pluck('auction_uuid')->toArray())
                ->where('is_active', true)
                ->with(['items', 'category', 'items.condition'])
                ->addSelect(['highest_bidder' => 
                    Bid::select('user_uuid')->whereColumn('auction_uuid', 'auctions.uuid')->orderByDesc('amount')->limit(1)])
                ->get();

            $auctions_action_required = 
                $user->auctions()
                    ->withCount(['bids', 'items'])
                    ->whereIn('uuid', $this->getSecondChanceAuctions())
                    ->with(['items', 'category', 'items.condition'])
                    ->union(
                        $user->auctions() // auctions that have ended without bids
                        ->withCount(['bids', 'items'])
                        ->whereIn('uuid', $this->getAuctionsEndedWithNoBids())
                        ->whereDoesntHave('bids')
                        ->with(['items', 'category', 'items.condition'])
                    )
                    ->get();

            $auctions_won = Auction::withCount(['bids', 'items'])
                ->whereIn('uuid', 
                    Winner::where('user_uuid', $uuid)->pluck('auction_uuid')->toArray())
                ->with(['items', 'category', 'items.condition'])
                ->orderByDesc('bids_count')
                ->get();

            $waiting_for_payment = Auction::withCount(['bids', 'items'])
                ->whereIn('uuid', Winner::whereIn('auction_uuid', $user->auctions()->pluck('uuid')->toArray())
                    ->pluck('auction_uuid')->toArray())
                ->with(['items', 'category', 'items.condition'])
                ->orderByDesc('bids_count')
                ->get();

            return view('profile.profile', compact('user', 'all_auctions', 'active_auctions', 'favourited', 'active_bids', 'auctions_won', 'auctions_action_required', 'waiting_for_payment'));
        } else {
            return view('profile.profile', compact('user', 'active_auctions'));
        }

    }

    public function sellAnyway($uuid){
        $auction = Auction::where('uuid', $uuid)->firstOrFail();
        app()->make(AuctionRepositoryInterface::class)->createWinner($auction);
        return redirect()->back();
    }
}
