<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Item;
use App\Models\Transaction;
use App\Services\ImageService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function bid(Request $request, $item_uuid){
        $bid_amount = $request->input('bid_amount');

        $increments = Bid::incremets();

        if(!is_numeric($bid_amount)){
            return back()->with('error', 'Bid amount must be a number');
        }
    }

    public function buy(Request $request, $item_uuid){
        $item = Item::where('uuid', $item_uuid)->firstOrFail();
        $auction = Auction::where('uuid', $item->auction_uuid)->firstOrFail();
        $quantity = $request->input('quantity');
        $item_price = $item->price;
        $user_balance = $request->user()->balance;

        if(!is_numeric($quantity)){
            return back()->with('error', 'Quantity must be a number');
        }

        if($item->quantity < $quantity){
            return back()->with('error', 'There are not enough items in stock');
        } else {
            if($user_balance < $item_price * $quantity){
                return back()->with('error', 'You do not have enough balance to buy this item');
            } else {
                $request->user()->balance -= $item_price * $quantity;
                $request->user()->save();
    
                $item->decrement('quantity', $quantity);

                if($item->quantity == 0){
                    if($item->image)
                        $this->imageService->destroyImage($item->uuid);
                    $item->delete();
                    if($auction->items->count() == 0){
                        $auction->delete();
                        return redirect()->route('home')->with('success', 'You have successfully bought this item');
                    }
                }
    
                $this->createTransaction($request->user()->uuid, $item_price * $quantity, 'payin');
    
                return back()->with('success', 'You have successfully bought this item');
            }
        }
    }

    public function createTransaction($uuid, $amount, $transaction_type){
        Transaction::create([
            'user_uuid' => $uuid,
            'amount' => $amount,
            'transaction_type' => $transaction_type
        ]);
    }
}
