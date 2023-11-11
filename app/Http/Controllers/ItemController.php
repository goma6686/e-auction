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
        ->leftJoin('items', 'auctions.uuid', '=', 'items.auction_uuid')
        ->leftJoin('categories', 'auctions.category_id', '=', 'categories.id')
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
            'end_time' => 'required|date|after:today',
        ]);

        $auction = new Auction();
        $auction->title = $request->input('title');
        $auction->description = $request->input('description');
        $auction->category_id = $request->input('category');
        $auction->user_uuid = $request->user()->uuid;

        if ($request->input('is_active') != null) {
            $auction->is_active = true;
            $auction->start_time = now();
        }
        else {
            $auction->is_active = false;
        }
        $auction->end_time = $request->input('end_time');
        $auction->bidder_count = 0;
        $auction->type_id = 1;
        $auction->save();

        $auction->items()->create([
            'title' => $request->input('item_title'),
            'condition_id' => $request->input('condition'),
            'current_price' => $request->input('price'),
            'auction_uuid' => $auction->uuid,
        ]);

        if($request->hasFile('image')) {
            $this->uploadImage($request, Item::where('auction_uuid', $auction->uuid)->latest()->first()->uuid);
        }

        return redirect()->back();
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

        /*$item = new Item(['title' => $request->input('title')],
        ['description' => $request->input('description')],
        ['condition_id' => $request->input('condition')],
        ['category_id' => $request->input('category')],
        ['current_price' => $request->input('price')]);

        $auction = Auction::where('item_uuid', $uuid)->first();

        $item->auctions()->save($auction);*/

        return redirect()->back();
    }

    public function destroy($uuid){
        $item = Item::find($uuid);
        if(isset($item->image)){
            unlink(public_path('/images/' . $item->image));
        }
        
        $auction = Auction::find($item->auction_uuid);

        if ($auction->type_id == 1){
            $auction->items()->delete();
            $auction->delete();
        }
        else {
            $auction->where('item_uuid', $uuid)->delete();
        }
        
        return redirect()->back();
    }

    public function destroyImage($uuid){
        $item = Item::find($uuid);
        unlink(public_path('/images/' . $item->image));
        $item->image = null;
        $item->save();

        return redirect()->back();
    }

    public function uploadImage(Request $request, $uuid){
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);
        $item = Item::find($uuid);
        $file = $request->file('image');
        $imageName = time() . '_' . $file->getClientOriginalName();
        $item->image = $imageName;
        $request->image->move(public_path('images'), $imageName);
        $item->save();
    }
}
