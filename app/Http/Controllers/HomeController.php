<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Auction;
use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $auction_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->leftJoin('conditions', 'conditions.id', '=', 'items.condition_id')
            ->orderByDesc('auctions.bidder_count')
            ->distinct('items.category_uuid')
            ->take(3)
            ->get();

        return view('welcome', compact('categories', 'auction_items'));
    }

    public function home(){
        $all_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->paginate(10);
        $categories = Category::all();

        return view ('home', compact('categories', 'all_items'));
    }

    public function category(Request $request, $category){
        if($category == 'all')
            return redirect()->route('home');
        else {
            $all_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
            ->leftJoin('categories', 'categories.id', '=', 'items.category_id')
            ->where('categories.category', $category)
            ->paginate(10);
            $categories = Category::all();

            return view ('home', compact('categories', 'all_items'));
        }
        
    }
}
