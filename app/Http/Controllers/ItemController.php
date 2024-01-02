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

    public function edit($uuid, $route){
        $conditions = Condition::all();

        $auction_item = Item::where('uuid', $uuid)
        ->with('condition')
        ->first();

        $auction_type = Auction::where('uuid', $auction_item->auction_uuid)
            ->select('type_id')
            ->first();
            
        return view('auction.edit.item', compact('auction_item', 'conditions', 'auction_type', 'route'));
    }

    public function update(Request $request, $uuid, $route){
        $request->validate([
            'title' => 'required|max:255',
            'condition' => 'required',
            'price' => 'sometimes|numeric|min:00.01',
        ]);

        $item = Item::find($uuid);
        $item->title = $request->input('title');
        $item->condition_id = $request->input('condition');

        if($request->input('quantity')){
            $item->quantity = $request->input('quantity');
        }
        if($request->input('price') && $request->input('price') < $item->price){
            $item->price = $request->input('price');
        }

        $item->save();
        $item->refresh();
        $user_id = (Auction::where('uuid', $item->auction_uuid)->first())->user_uuid;
        
        if($route === 'profile'){
            return redirect()->route('profile.all', ['uuid' => $user_id])->with('success', 'Changes saved successfully');
        } else {
            return redirect()->route('admin.items')->with('success', 'Changes saved successfully');
        }
    }

    public function destroy($uuid, $route){
        $item = Item::with('auctions')->where('uuid', $uuid)->first();

        $auction = Auction::withCount('items')->where('uuid', $item->auction_uuid)->first();
        $user_id = $auction['user_uuid'];

        if($auction->items_count == 1){
            $this->imageService->destroyImage($item->uuid);
            $auction->items()->delete();
            $auction->delete();
        }else{
            if($item->image)
            $this->destroyImage($uuid);
            $item->delete();
        }

        if($route === 'profile'){
            return redirect()->route('profile.all', ['uuid' => $user_id])->with('success', 'Item deleted successfully');
        } else {
            return redirect()->route('back', ['page' => $route])->with('success', 'Item deleted successfully');
        }
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
