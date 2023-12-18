<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImageService;

use App\Models\Auction;
use App\Models\Condition;
use App\Models\Category;
use App\Models\User;
use App\Models\Bid;

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
            'end_time' => $request->end_time ?? null,
            'is_active' => $request->is_active === '1' ? true : false,
            'type_id' => $type,
            'reserve_price' => $request->reserve_price ?? null,
            'price' => $request->price ?? null,
            'buy_now_price' => $request->buy_now_price ?? null,
        ]);

        foreach($request->items as $item) {
            $newItem = $auction->items()->create([
                'title' => $item['item_title'],
                'condition_id' => $item['condition'],
                'price' => $item['price'] ?? null,
                'quantity' => $item['quantity'] ?? 1,
                'auction_uuid' => $auction->uuid,
            ]);

            if(isset($item['image'])){
                $this->imageService->uploadImage($item['image'], $newItem->uuid);
            }
        }

        $auction->refresh();

        return redirect()->route('show-auction', $auction->uuid)->with('success', 'Auction created successfully');
    }

    public function show(Request $request, $uuid) {
        $auction = Auction::withCount('items')->with(['items', 'category', 'items.condition'])->find($uuid);

        $seller = User::find($auction->user_uuid);

        $auction_count = $seller->loadCount(['auctions' => function ($query) {
            $query->where('is_active', true);
        }])->auctions_count;

        $bids = Bid::where('auction_uuid', $auction->uuid)->orderBy('amount', 'desc')->take(3)->get();
        $max_bid = $auction->bids()->max('amount');
        $buy_now_price = $auction->buy_now_price;

        if($auction->type_id == 2){
            if(!$max_bid || $max_bid < $auction->price){
                $max_bid = $auction->price;
            }
            
            $increment = Bid::incremets()->collect()->filter(function ($increment) use ($max_bid) {
                return $max_bid >= $increment['from'] && $max_bid <= $increment['to'];
            })->first();
            
            for($i = 0; $i < 3; $i++){
                $bids[$i] = $max_bid + ($i+1)*$increment['increment'];
            }
            $bids = $bids->toArray();
        }
    
        return view('auction.full', compact('auction', 'seller', 'auction_count', 'bids', 'buy_now_price', 'max_bid'));
    }

    public function destroy($uuid){
        $auction = Auction::find($uuid);
        $user_id = $auction->user_uuid;
        foreach($auction->items as $item) {
            $this->imageService->destroyImage($item->uuid);
        }
        $auction->items()->delete();
        $auction->delete();
        
        return redirect()->route('profile.all', ['uuid' => $user_id]);
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
        $user_id = $auction->user_uuid;
        $auction->title = $request->input('title');
        $auction->description = $request->input('description');
        $auction->is_active = $request->input('is_active') != null ? true : false;
        $auction->category_id = $request->input('category');
        if($request->input('end_time')){
            $auction->end_time = $request->input('end_time');
        }
        if($request->input('reserve_price')){
            $auction->reserve_price = $request->input('reserve_price');
        }
        if($request->input('buy_now_price')){
            $auction->buy_now_price = $request->input('buy_now_price');
        }
        if($request->input('price')){
            $auction->price = $request->input('price');
        }
        $auction->save();

        $auction->refresh();

        return redirect()->route('profile.all', ['uuid' => $user_id])->with('success', 'Changes saved successfully');
    }

}
