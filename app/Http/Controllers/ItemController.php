<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Auction;
use App\Models\Item;
use App\Models\User;
use App\Models\Condition;

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

        $count = $seller->loadCount(['auctions' => function ($query) {
            $query->where('is_active', true);
        }])->auctions_count;

        return view('item.full', compact('item', 'seller', 'count'));
    }

    public function create(Request $request) {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('item.create', compact('categories', 'conditions'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0.01',
            'image' => 'image|mimes:jpeg,png,jpg|max:5120',
            'end_time' => 'required|date|after:today',
        ]);
        
        //return dd($request->all());
        $item = new Item();
        $item->title = $request->input('title');
        $item->description = $request->input('description');
        $item->category_id = $request->input('category');
        $item->condition_id = $request->input('condition');
        $item->current_price = $request->input('price');
        $item->user_uuid = $request->user()->uuid;

        if($request->hasFile('image')) {
            $imageName = $item->uuid . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $item->image = $imageName;
        }

        $item->save();

        $auction = new Auction();
        $auction->item_uuid = $item->uuid;
        $auction->user_uuid = $item->user_uuid;
        $auction->current_price = $item->current_price;
        $auction->next_price = $item->current_price;
        $auction->end_time = $request->input('end_time');
        if ($request->input('is_active') != null) {
            $auction->is_active = true;
            $auction->start_time = now();
        }
        else {
            $auction->is_active = false;
        }
        $auction->bidder_count = 0;
        $auction->save();
        return redirect('/');
    }
}
