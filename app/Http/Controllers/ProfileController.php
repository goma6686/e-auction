<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile(Request $request, $uuid) {
        $user = User::find($uuid);

        $active_auctions = $user->auctions()
                ->where('is_active', true)
                ->where('end_time', '>', now())
                ->with(['items', 'category', 'items.condition'])
                ->select(
                    '*',
                DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
                DB::raw('(SELECT MIN(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
                DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as price'),
                DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
                )
                ->get();

        if(Auth::check() && Auth::user()->uuid == $uuid) {
            
            $all_auctions = 
                $user->auctions()->with(['items', 'category', 'items.condition'])
                ->select(
                    '*',
                DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
                DB::raw('(SELECT MIN(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
                DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as price'),
                DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
                )
                ->get();

                //return dd($all_auctions);

            return view('profile.profile', compact('user', 'all_auctions', 'active_auctions'));
        } else {
            return view('profile.profile', compact('user', 'active_auctions'));
        }
    }
}
