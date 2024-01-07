<?php

namespace App\Http\Controllers;

use App\Events\BidPlaced;
use App\Mail\AuctionOutbid;
use App\Models\Auction;
use App\Models\Item;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Bid;
use App\Notifications\OutbidNotification;
use Illuminate\Support\Facades\Notification;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        if($auction->end_time < now()){
            return back()->with('error', 'This auction has ended');
        }

        if($bid_amount < $auction->price){
            return back()->with('error', 'Bid must be higher than the current price');
        }

        if($auction->bids->count() > 0){
            $highest_bid =  $auction->bids()->max('amount');
            
        } else {
            $highest_bid = $auction->price;
        }

        if($bid_amount <= $highest_bid){
            return back()->with('error', 'Bid must be higher than the current price');
        } else {
            if($auction->bids->count() > 0){
                $highest_bidder = User::where('uuid', $auction->bids()->where('amount', $highest_bid)->pluck('user_uuid')->first())->firstOrFail();
                $highest_bidder->notify(new OutbidNotification($auction, $highest_bidder, $request->user()->uuid));
            }    


            $auction->price = $bid_amount;
            $auction->save();

            $this->createTransaction($request->user()->uuid, $bid_amount, 'payin');

            $auction->bids()->create([
                'user_uuid' => $request->user()->uuid,
                'amount' => $bid_amount,
                'created_at' => now()
            ]);

            $auction->refresh();

            BidPlaced::dispatch($auction);
            if($bid_amount < $auction->reserve_price){
                return back()->with('success', 'Reserve price has not been met! Bid has been placed');
            }
            return back()->with('success', 'You have successfully bid this item');
        }
    }

    public function buy(Request $request, $item_uuid){
        $item = Item::where('uuid', $item_uuid)->firstOrFail();
        $auction = Auction::where('uuid', $item->auction_uuid)->firstOrFail();
        $quantity = $request->input('quantity');

        if($request->user()->uuid == $auction->user_uuid){
            return back()->with('error', 'You cannot buy your own item');
        }
        
        $user_balance = $request->user()->balance;

        $auction->type_id == 1 ? $price = $item->price : $price = $auction->buy_now_price;

        if($item->quantity < $quantity){
            return back()->with('error', 'There are not enough items in stock');
        } else if($auction->type_id == 1) {
            if(!is_numeric($quantity)){
                return back()->with('error', 'Quantity must be a number');
            }
            if($user_balance < $price * $quantity){
                return back()->with('error', 'You do not have enough balance to buy this item');
            } else {
                $request->user()->balance -= $price * $quantity;
                $request->user()->save();
    
                $item->decrement('quantity', $quantity);
                $item->increment('quantity_sold', $quantity);

                if($item->quantity == 0){
                    if($item->image)
                        $this->imageService->destroyImage($item->uuid);
                    $item->delete();
                    if($auction->items->count() == 0){
                        $auction->delete();
                        return redirect()->route('home')->with('success', 'You have successfully bought this item');
                    }
                }
    
                $this->createTransaction($request->user()->uuid, $price * $quantity, 'payin');
    
                return back()->with('success', 'You have successfully bought this item');
            }
        } else {
            if($user_balance < $price){
                return back()->with('error', 'You do not have enough balance to buy this item');
            } else {
                $request->user()->balance -= $price;
                $request->user()->save();

                foreach($auction->items as $item) {
                    if($item->image)
                        $this->imageService->destroyImage($item->uuid);
                    $item->delete();
                }
                $auction->delete();
                $this->createTransaction($request->user()->uuid, $price, 'payin');
                return redirect()->route('home')->with('success', 'You have successfully bought this item');
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
