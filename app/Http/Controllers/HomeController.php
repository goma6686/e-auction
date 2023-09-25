<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Auction;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $auction_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.item_id', '=', 'items.uuid')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('conditions', 'conditions.id', '=', 'items.condition_id')
            ->orderByDesc('auctions.bidder_count')
            ->distinct('items.category_id')
            ->take(3)->get();
        
        return view('welcome', compact('categories', 'auction_items')); //TODO: list most popular item for each category
    }
}
