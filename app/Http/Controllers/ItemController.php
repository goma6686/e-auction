<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImageService;

use App\Models\Category;
use App\Models\Auction;
use App\Models\Item;
use App\Models\Condition;

class ItemController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index(Request $request){
        $category = Category::find($request->input('category'));
        $items = $category ? $category->items : Item::all();

        return view('home', compact('items'));
    }

    public function edit($uuid){
        $conditions = Condition::all();

        $auction_item = Item::where('uuid', $uuid)
        ->with('condition')
        ->first();

        $auction_type = Auction::where('uuid', $auction_item->auction_uuid)
            ->select('type_id')
            ->first();
            
        return view('auction.edit.item', compact('auction_item', 'conditions', 'auction_type'));
    }

    public function update(Request $request, $uuid){
        $request->validate([
            'title' => 'required|max:255',
            'condition' => 'required',
            'price' => 'required|numeric|min:0.01',
        ]);

        $item = Item::find($uuid);
        $item->title = $request->input('title');
        $item->price = $request->input('price');
        $item->condition_id = $request->input('condition');

        if($request->input('quantity')){
            $item->quantity = $request->input('quantity');
        }

        if($request->input('reserve_price')){
            $item->reserve_price = $request->input('reserve_price');
        }

        $item->save();

        return redirect()->back();
    }

    public function destroy($uuid){
        $item = Item::find($uuid);
        $this->destroyImage($uuid);
        //$this->imageService->destroyImage($uuid);
        $item->delete();
        
        return redirect()->back();
    }

    public function destroyImage($uuid){
        $this->imageService->destroyImage($uuid);
        return redirect()->back();
    }

    public function uploadImage(Request $request, $uuid){
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);

        $this->imageService->uploadImage($request->file('image'), $uuid);
        
        return redirect()->back();
    }
}
