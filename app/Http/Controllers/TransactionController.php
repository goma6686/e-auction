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

    public function bid(Request $request, $auction_uuid, $bid_amount){
        $auction = Auction::where('uuid', $auction_uuid)->firstOrFail();
        $bid_amount = $bid_amount;
        $user_balance = $request->user()->balance;

        if($auction->end_time < now()){
            return back()->with('error', 'This auction has ended');
        }

        if($bid_amount < $auction->price){
            return back()->with('error', 'Bid must be higher than the current price');
        }

        if($user_balance < $bid_amount){
            return back()->with('error', 'You do not have enough balance to bid this amount');
        }

        if($auction->bids->count() > 0){
            $highest_bid =  $auction->bids()->max('amount');
        } else {
            $highest_bid = $auction->price;
        }

        if($bid_amount <= $highest_bid){
            return back()->with('error', 'Bid must be higher than the current price');
        } else {
            $request->user()->balance -= $bid_amount;
            $request->user()->save();

            $auction->price = $bid_amount;
            $auction->save();

            $this->createTransaction($request->user()->uuid, $bid_amount, 'payin');

            $auction->bids()->create([
                'user_uuid' => $request->user()->uuid,
                'amount' => $bid_amount,
                'created_at' => now()
            ]);
            /*Bid::create([
                'user_uuid' => $request->user()->uuid,
                'auction_uuid' => $auction->uuid,
                'amount' => $bid_amount,
                'created_at' => now()
            ]);*/

            return back()->with('success', 'You have successfully bid this item');
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
