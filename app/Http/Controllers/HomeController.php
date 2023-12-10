<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Auction;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $auction_items = Auction::withCount(['bids', 'items'])
            ->where('is_active', true)
            ->with(['items', 'category', 'items.condition'])
            ->addSelect([
                'max_price' => Item::selectRaw('MAX(price)')
                    ->whereColumn('auction_uuid', 'auctions.uuid')
                    ->havingRaw('COUNT(*) > 1'),
                'min_price' => Item::selectRaw('MIN(price)')
                    ->whereColumn('auction_uuid', 'auctions.uuid')
                    ->havingRaw('COUNT(*) > 1'),
                'buy_price' => Item::selectRaw('MAX(price)')
                    ->whereColumn('auction_uuid', 'auctions.uuid')
                    ->havingRaw('COUNT(*) = 1'),
                'count' => Item::selectRaw('COUNT(*)')
                    ->whereColumn('auction_uuid', 'auctions.uuid'),
            ])
            ->orderByDesc('bids_count')
            ->groupBy('auctions.category_id', 'auctions.uuid')
            ->take(3)
            ->get();

        return view('welcome', compact('categories', 'auction_items'));
    }

    public function home(){
        $categories = Category::all();

        $auctions = Auction::where('is_active', true)
            ->with(['items', 'category', 'items.condition'])
            ->select(
                '*',
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
            DB::raw('(SELECT MIN(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as buy_price'),
            DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
            )
            ->orderByDesc('auctions.created_at')
            ->paginate(10);

        return view ('home', compact('categories', 'auctions'));
    }

    public function auctions(){
        $categories = Category::all();

        $auctions = Auction::where('is_active', true)
            ->where('type_id', '=', "2")
            ->with(['items', 'category', 'items.condition'])
            ->select(
                '*',
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
            DB::raw('(SELECT MIN(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as buy_price'),
            DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
            )
            ->orderByDesc('auctions.created_at')
            ->paginate(10);

        return view ('home', compact('categories', 'auctions'));
    }

    public function buy(){
        $categories = Category::all();

        $auctions = Auction::where('is_active', true)
            ->where('type_id', '=', "1")
            ->with(['items', 'category', 'items.condition'])
            ->select(
                '*',
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
            DB::raw('(SELECT MIN(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as buy_price'),
            DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
            )
            ->orderByDesc('auctions.created_at')
            ->paginate(10);
            //return dd($auctions);
        return view ('home', compact('categories', 'auctions'));
    }

    public function category(Request $request, $category){
        $categories = Category::all();

        if($category === 'all')
            return redirect()->route('home');
        else {
            $auctions = Auction::where('is_active', true)
            ->where('category_id', Category::where('category', $category)->first()->id)
            ->with(['items', 'category', 'items.condition'])
            ->select(
                '*',
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
            DB::raw('(SELECT MIN(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
            DB::raw('(SELECT MAX(price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as buy_price'),
            DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
            )
            ->paginate(10);

            //return dd($auctions);
            return view ('home', compact('categories', 'auctions'));
        }
        
    }
}
