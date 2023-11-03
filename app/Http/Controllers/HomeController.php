<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Auction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $auction_items = Auction::where('is_active', true) //Paima top 3 kategorijas aukcionu su didziausiu bidder skaiciumi
            ->leftJoin('items', 'auctions.item_uuid', '=', 'items.uuid')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('conditions', 'conditions.id', '=', 'items.condition_id')
            ->orderByDesc('auctions.bidder_count')
            ->distinct('items.category_uuid')
            ->take(3)->get();

        return view('welcome', compact('categories', 'auction_items'));
    }

    public function home(){
        $all_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.item_uuid', '=', 'items.uuid')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->paginate(9);
        $categories = Category::all();

        return view ('home', compact('categories', 'all_items'));
    }

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
