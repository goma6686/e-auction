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

    public function create(Request $request) {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('auction.create', compact('categories', 'conditions'));
    }

    public function store(Request $request) {

        /*$request->validate([
            'title' => 'required',
            'description' => 'required',
            'end_time' => 'required|date|after:today',
            'category' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0.01',
        ]);*/
        if ($request->is_active != null) {
            $is_active = true;
            $start_time = now();
        }
        else {
            $is_active = false;
            $start_time = null;
        }

        $auction = Auction::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'user_uuid' => $request->user()->uuid,
            'end_time' => $request->end_time,
            'bidder_count' => 0,
            'is_active' => $is_active,
            'start_time' => $start_time,
        ]);

        foreach($request->items as $item) {
            $newItem = $auction->items()->create([
                'title' => $item['item_title'],
                'condition_id' => $item['condition'],
                'current_price' => $item['price'],
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
            $query->where('is_active', true)->where('end_time', '>', now());
        }])->auctions_count;

        return view('item.full', compact('auction', 'seller', 'auction_count'));
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
}
