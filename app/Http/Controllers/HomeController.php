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

        $auction_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
            ->leftJoin('categories', 'categories.id', '=', 'auctions.category_id')
            ->with(['items' => function ($query) {
                $query->select('auction_uuid', 'image')
                ->first();
            }])
            ->select(
                'auctions.*',
                'categories.category',
            DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
            DB::raw('(SELECT MIN(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
            DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as price'),
            DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
            )
            ->orderByDesc('auctions.bidder_count')
            ->groupBy('auctions.category_id', 'auctions.uuid')
            ->take(3)
            ->get();

        return view('welcome', compact('categories', 'auction_items'));
    }

    public function home(){
        $categories = Category::all();

        $all_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
            ->leftJoin('categories', 'categories.id', '=', 'auctions.category_id')
            ->with(['items' => function ($query) {
                $query->select('auction_uuid', 'image')
                ->first();
            }])
            ->select(
                '*',
            DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as max_price'),
            DB::raw('(SELECT MIN(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) > 1) as min_price'),
            DB::raw('(SELECT MAX(current_price) FROM items WHERE items.auction_uuid = auctions.uuid HAVING COUNT(*) = 1) as price'),
            DB::raw('(SELECT COUNT(*) FROM items WHERE items.auction_uuid = auctions.uuid) as count')
            )
            ->paginate(10);

        return view ('home', compact('categories', 'all_items'));
    }

    public function category(Request $request, $category){
        if($category == 'all')
            return redirect()->route('home');
        else {
            $all_items = Auction::where('is_active', true)
            ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
            ->leftJoin('categories', 'categories.id', '=', 'auctions.category_id')
            ->where('categories.category', $category)
            ->paginate(10);
            $categories = Category::all();

            return view ('home', compact('categories', 'all_items'));
        }
        
    }
}
