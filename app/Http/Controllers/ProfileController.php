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

        $active_items = Auction::where('auctions.user_uuid', $uuid)
                ->where('auctions.is_active', true)
                ->leftJoin('items', 'auctions.item_uuid', '=', 'items.uuid')
                ->get();

        if(Auth::check() && Auth::user()->uuid == $uuid) {
            $all_items = Auction::where('auctions.user_uuid', $uuid)
                ->leftJoin('items', 'auctions.item_uuid', '=', 'items.uuid')
                ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
                ->leftJoin('conditions', 'conditions.id', '=', 'items.condition_id')
                ->get();

            return view('profile.profile', compact('user', 'all_items', 'active_items'));
        } else {
            return view('profile.profile', compact('user', 'active_items'));
        }
    }
}
