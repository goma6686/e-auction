<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Auction;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    public function index(Request $request){
        $category = Category::find($request->input('category'));
        $items = $category ? $category->items : Item::all();

        return view('home', compact('items'));
    }

    public function show(Request $request, $uuid) {
        $item = Auction::where('item_uuid', $uuid)
        ->leftJoin('items', 'auctions.item_uuid', '=', 'items.uuid')
        ->leftJoin('categories', 'items.category_id', '=', 'categories.id')
        ->leftJoin('conditions', 'items.condition_id', '=', 'conditions.id')
        ->first();
        $seller = User::find($item->user_uuid);
        $count = $seller->loadCount('auctions')->auctions_count;

        return view('item.full', compact('item', 'seller', 'count'));
    }

    public function create(Request $request) {
        $categories = Category::all();

        return view('item.create', compact('categories'));
    }
}
