<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Auction;

class HomeController extends Controller
{
    public function index()
    {

        $auction_items = Auction::withCount(['bids', 'items'])
            ->where('is_active', true)
            ->with(['items', 'category', 'items.condition'])
            ->withMin('items', 'price')
            ->orderByDesc('bids_count')
            ->groupBy('auctions.category_id', 'auctions.uuid')
            ->take(3)
            ->get()->toArray();
            
        return view('welcome', compact('auction_items'));
    }

    public function home(){
        $category = 'all';

        return view ('home', compact('category'));
    }
}
