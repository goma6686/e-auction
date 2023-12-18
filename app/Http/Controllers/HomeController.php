<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Auction;
use Algolia\ScoutExtended\Facades\Algolia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $auction_items = Auction::withCount(['bids', 'items'])
            ->where('is_active', true)
            ->with(['items', 'category', 'items.condition'])
            ->withMin('items', 'price')
            ->orderByDesc('bids_count')
            ->groupBy('auctions.category_id', 'auctions.uuid')
            ->take(3)
            ->get();

        return view('welcome', compact('categories', 'auction_items'));
    }

    public function home(){
        $categories = Category::all();
        $category = 'all';

        $auctions = Auction::withCount(['bids'])
            ->where('is_active', true)
            ->with(['items', 'category'])
            ->withMin('items', 'price')
            ->orderByDesc('auctions.created_at')
            ->paginate(12);

        return view ('home', compact('categories', 'auctions', 'category'));
    }

    public function auctions(){
        $categories = Category::all();

        $auctions = Auction::withCount(['bids'])
        ->where('is_active', true)
        ->where('type_id', '=', '2')
        ->with(['items', 'category'])
        ->withMin('items', 'price')
        ->orderByDesc('auctions.created_at')
        ->paginate(12);

        return view ('home', compact('categories', 'auctions'));
    }

    public function buy(){
        $categories = Category::all();

        $auctions = Auction::withCount(['bids'])
            ->where('is_active', true)
            ->where('type_id', '=', '1')
            ->with(['items', 'category'])
            ->withMin('items', 'price')
            ->orderByDesc('auctions.created_at')
            ->paginate(12);

        return view ('home', compact('categories', 'auctions'));
    }

    public function category(Request $request, $category){
        $categories = Category::all();

        if($category === 'all')
            return redirect()->route('home');
        else {
            $auctions = Auction::withCount(['bids'])
            ->where('is_active', true)
            ->where('category_id', Category::where('category', $category)->first()->id)
            ->with(['items', 'category', 'items.condition'])
            ->withMin('items', 'price')
            ->orderByDesc('auctions.created_at')
            ->paginate(10);

            return view ('home', compact('categories', 'auctions', 'category'));
        }
        
    }
}
