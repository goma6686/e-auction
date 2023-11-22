<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImageService;

use App\Models\Auction;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;

class AuctionController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create(Request $request, $type) {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('auction.create', compact('categories', 'conditions', 'type'));
    }

    public function store(Request $request, $type) {

        /*$request->validate([
            'title' => 'required',
            'description' => 'required',
            'end_time' => 'required|date|after:today',
            'category' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0.01',
        ]);*/

        $auction = Auction::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'user_uuid' => $request->user()->uuid,
            'start_time' => $request->start_time ?? null,
            'end_time' => $request->end_time ?? null,
            'bidder_count' => 0,
            'is_active' => $request->is_active === '1' ? true : false,
            'type_id' => $type,
        ]);

        foreach($request->items as $item) {
            $newItem = $auction->items()->create([
                'title' => $item['item_title'],
                'condition_id' => $item['condition'],
                'price' => $item['price'],
                'quantity' => $item['quantity'] ?? 1,
                'buy_now_price' => $item['buy_now_price'] ?? null,
                'reserve_price' => $item['reserve_price'] ?? null,
                'auction_uuid' => $auction->uuid,
            ]);

            if(isset($item['image'])){
                $this->imageService->uploadImage($item['image'], $newItem->uuid);
            }
        }

        return redirect()->route('show-auction', $auction->uuid);
    }

    public function show(Request $request, $uuid) {
        $auction = Auction::withCount('items')->with(['items', 'category', 'items.condition'])->find($uuid);

        $seller = User::find($auction->user_uuid);

        $auction_count = $seller->loadCount(['auctions' => function ($query) {
            $query->where('is_active', true);
        }])->auctions_count;

        return view('auction.full', compact('auction', 'seller', 'auction_count'));
    }

    public function destroy($uuid){
        $auction = Auction::find($uuid);
        foreach($auction->items as $item) {
            $this->imageService->destroyImage($item->uuid);
        }
        $auction->items()->delete();
        $auction->delete();
        
        return redirect()->back();
    }

    public function edit($uuid){
        $categories = Category::all();

        $auction = Auction::where('uuid', $uuid)
        ->with('category')
        ->first();
        
        return view('auction.edit.auction', compact('auction', 'categories'));
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'end_time' => 'date|after:today',
        ]);

        $auction = Auction::find($uuid);
        $auction->title = $request->input('title');
        $auction->description = $request->input('description');
        $auction->is_active = $request->input('is_active') != null ? true : false;
        $auction->category_id = $request->input('category');
        if($request->input('end_time')){
            $auction->end_time = $request->input('end_time');
            $auction->start_time = $request->input('start_time');
        }
        $auction->save();

        return redirect()->back();
    }

}
