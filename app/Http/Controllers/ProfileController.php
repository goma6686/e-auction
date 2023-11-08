<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Auction;

class ProfileController extends Controller
{
    public function profile(Request $request, $uuid) {
        $user = User::find($uuid);

        $active_items = $user->auctions()
                ->where('is_active', true)
                ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
                ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
                ->leftJoin('conditions', 'conditions.id', '=', 'items.condition_id')
                ->get();

        if(Auth::check() && Auth::user()->uuid == $uuid) {
            $all_items = $user->auctions()
                ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
                ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
                ->leftJoin('conditions', 'conditions.id', '=', 'items.condition_id')
                ->get();

            return view('profile.profile', compact('user', 'all_items', 'active_items'));
        } else {
            return view('profile.profile', compact('user', 'active_items'));
        }
    }
}
