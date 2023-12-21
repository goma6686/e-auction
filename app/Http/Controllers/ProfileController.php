<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function profile(Request $request, $uuid) {
        $user = User::find($uuid);
        $categories = Category::all();

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
                ->withMin('items', 'price')
                ->get();

            $favourited = Auction::whereIn('uuid', 
                Auth::user()->favourites->pluck('auction_uuid')->toArray())
                ->withCount(['bids'])
                ->with(['items', 'category', 'items.condition', 'type'])
                ->withMin('items', 'price')
                ->get();

            $active_bids = Auction::withCount(['bids', 'items'])
                ->whereIn('uuid', 
                Auth::user()->bids->pluck('auction_uuid')->toArray())
                ->where('is_active', true)
                ->with(['items', 'category', 'items.condition'])
                ->get();

            $auctions_no_bids = Auction::withCount(['bids', 'items'])
                ->where('user_uuid', $uuid)
                ->where('is_active', false)
                ->with(['items', 'category', 'items.condition'])
                ->orderByDesc('bids_count')
                ->get();

            return view('profile.profile', compact('user', 'all_auctions', 'active_auctions', 'favourited', 'active_bids', 'auctions_no_bids', 'categories'));
        } else {
            return view('profile.profile', compact('user', 'active_auctions', 'categories'));
        }
    }
}
