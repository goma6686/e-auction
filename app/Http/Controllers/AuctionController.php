<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImageService;

use App\Models\Auction;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Bid;
use App\Repositories\Interfaces\AuctionRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create(Request $request, $type) {
        $conditions = Condition::all();

        return view('auction.create', compact('conditions', 'type'));
    }

    public function store(Request $request, $type): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:3',
            'description' => 'required',
            'category' => 'required',
            'end_time' => 'sometimes|date|after:today',
            'reserve_price' => [
                'sometimes', 'numeric', 'min:'.$request->price+1, 'max:999999.99'],
            'price' => 'sometimes|numeric|min:00.01|max:999999.99',
            'buy_now_price' => [
                'numeric', 'min:10.00', 'min:'.$request->price+1],
            'items.*.item_title' => 'required|max:255|min:3',
            'items.*.condition' => 'required',
            'items.*.price' => 'sometimes|numeric|min:00.01|max:999999.99',
            'items.*.quantity' => 'sometimes|numeric|min:1|max:999',
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->all());
            return Redirect::back();
        }

        $auction = Auction::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'user_uuid' => $request->user()->uuid,
            'end_time' => $request->end_time ?? null,
            'is_active' => true,
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
        //$auction->update(); //Algolia
        $auction->searchable();

        return redirect()->route('show-auction', $auction->uuid)->with('success', 'Auction created successfully');
    }

    public function show(Request $request, $uuid) {
        $auction = Auction::withCount('items')->with(['items', 'category', 'items.condition'])->find($uuid);

        $auction_count = $auction->getAuctionSeller()->loadCount(['auctions' => function ($query) {
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
    
        return view('auction.full', compact('auction', 'auction_count', 'bids', 'buy_now_price', 'max_bid'));
    }

    public function destroy($uuid, $route){
        $auction = Auction::find($uuid);
        $user_id = $auction->user_uuid;
        foreach($auction->items as $item) {
            $this->imageService->destroyImage($item->uuid);
        }
        $auction->items()->delete();
        $auction->bids()->delete();
        $auction->winners()->delete();
        $auction->delete();
        
        if($route === 'profile'){
            return redirect()->route('profile.all', ['uuid' => $user_id])->with('success', 'Auction deleted successfully');;
        } else {
            return redirect()->route('back', ['page' => $route])->with('success', 'Auction deleted successfully');
        }
    }

    public function edit($uuid, $route){
        $auction = Auction::where('uuid', $uuid)
        ->with('category')
        ->first();
        
        return view('auction.edit.auction', compact('auction', 'route'));
    }

    public function update(Request $request, $uuid, $route): RedirectResponse
    {
        $auction = Auction::find($uuid);

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            /*'end_time' => [
                'sometimes',
                'date',
                'after:'.$auction->end_time,
            ],*/
            'end_time' => 'sometimes|date',
            'reserve_price' => [
                'exclude_if:'.Auth::user()->is_admin.',1',
                'numeric', 'min:'.($auction->price+1), 'max:'.($auction->reserve_price)],
            'price' => [
                'exclude_if:'.Auth::user()->is_admin.',1',
                'numeric', 'max:'.($auction->price)],
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->errors()->all());
            return Redirect::back();
        }

        $auction->title = $request->input('title');
        $auction->description = $request->input('description');
        $auction->is_active = $request->input('is_active') != null ? true : false;
        $auction->is_blocked = $request->input('is_blocked') != null ? true : false;
        $auction->category_id = $request->input('category');
        if($request->input('end_time')){
            if(Auth::user()->is_admin){
                $auction->end_time = $request->input('end_time');
            } else {
                if($request->input('end_time') > $auction->end_time){
                    $auction->end_time = $request->input('end_time');
                } else {
                    Session::flash('error', 'End time must be later than current end time');
                    return Redirect::back();
                }
            }
            $auction->end_time = $request->input('end_time');
        }
        if($request->input('reserve_price')){
            if(Auth::user()->uuid){
                
            }
            $auction->reserve_price = $request->input('reserve_price');
        }
        if($request->input('buy_now_price')){
            $auction->buy_now_price = $request->input('buy_now_price');
        }
        if($request->input('price')){
            $auction->price = $request->input('price');
        }
        if($request->input('created_at')){
            $auction->created_at = $request->input('created_at');
        }
        $auction->save();

        $auction->refresh();
        //$auction->update(); //Algolia
        $auction->searchable();

        if($route === 'profile'){
            return redirect()->route('profile.all', ['uuid' => $auction->user_uuid])->with('success', 'Changes saved successfully');
        } else {
            return redirect()->route('back', ['page' => $route])->with('success', 'Changes saved successfully');
        }
    }

}
