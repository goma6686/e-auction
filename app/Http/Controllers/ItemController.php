<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Auction;
use App\Models\Item;
use App\Models\Condition;

class ItemController extends Controller
{
    public function index(Request $request){
        $category = Category::find($request->input('category'));
        $items = $category ? $category->items : Item::all();

        return view('home', compact('items'));
    }

    public function create($uuid, $quantity) {
        $conditions = Condition::all();

        return view('item.itemform', compact('conditions', 'uuid', 'quantity'));
    }

    public function edit($uuid){
        $categories = Category::all();
        $conditions = Condition::all();

        $auction_item = Auction::where('item_uuid', $uuid)
        ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
        ->leftJoin('categories', 'auctions.category_id', '=', 'categories.id')
        ->leftJoin('conditions', 'items.condition_id', '=', 'conditions.id')
        ->first();

        return view('item.edit', compact('auction_item', 'categories', 'conditions'));
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0.01',
            'end_time' => 'required|date|after:today',
        ]);

        $item = Item::find($uuid);
        $item->title = $request->input('title');
        $item->description = $request->input('description');

        $item->condition_id = $request->input('condition');
        $item->category_id = $request->input('category');
        $item->current_price = $request->input('price');
        $item->save();

        $auction = Auction::where('item_uuid', $uuid)->first();
        $auction->end_time = $request->input('end_time');
        $auction->is_active = $request->input('is_active') != null ? true : false;
        $auction->save();

        return redirect()->back();
    }
}
