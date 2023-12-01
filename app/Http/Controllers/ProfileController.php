<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile(Request $request, $uuid) {
        $user = User::find($uuid);

        $active_auctions = $user->auctions()
                ->where('is_active', true)
                ->with(['items', 'category', 'items.condition'])
                ->select(
                    '*',
                DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
                DB::raw('(SELECT MIN(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
                DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as price'),
                DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
                )
                ->get();

        if(Auth::check() && Auth::user()->uuid == $uuid) {

            $favourites = Auth::user()->favourites->pluck('auction_uuid')->toArray();
            $favourited = Auction::whereIn('uuid', $favourites)->with(['items', 'category', 'items.condition', 'type'])->get();
            
            $all_auctions = 
                $user->auctions()->with(['items', 'category', 'items.condition', 'type'])
                ->select(
                    '*',
                DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
                DB::raw('(SELECT MIN(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
                DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as price'),
                DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
                )
                ->get();

            return view('profile.profile', compact('user', 'all_auctions', 'active_auctions', 'favourited'));
        } else {
            return view('profile.profile', compact('user', 'active_auctions'));
        }
    }
}
