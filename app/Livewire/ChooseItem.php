<?php

namespace App\Livewire;

use App\Events\EndAuction;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Condition;
use App\Models\Winner;
use App\Repositories\Interfaces\AuctionRepositoryInterface;
use DateTime;
use Livewire\Component;

class ChooseItem extends Component
{
    public $auction;
    public $items = [];
    public $item;
    public $condition;
    public $price;
    public $title;
    public $quantity;
    public $quantity_sold;
    public $selectedItem;
    public $type;
    public $auction_count;
    public $selected_uuid;
    public $bids;
    public $buy_now_price;

    public $isAcceptingBids;

    public function mount(Auction $auction, $bids){
        $this->buy_now_price = $auction->buy_now_price;
        $this->bids = $bids;
        $this->auction_count = $auction->getAuctionSeller()->auctions->where('is_active', true)->count();
        $this->type = $auction->type_id;
        $this->auction = $auction;
        $this->items = $auction->items;
        $this->item = $this->items[0];
        $this->selectedItem = $this->items[0];
        $this->selected_uuid = $this->items[0]['uuid'];
        $this->price = $this->item['price'];
        $this->condition = $this->item['condition']['condition'];
        $this->quantity = $this->item['quantity'] > 10 ? 'More than 10 left' : $this->item['quantity'].' left';
        $this->quantity_sold = $this->item['quantity_sold'] > 0 ? $this->item['quantity_sold']. ' sold' : '';
        $this->isAcceptingBids = $this->auction->getIsAcceptingBidsAttribute();

        $now = new DateTime(\Carbon\Carbon::now());
        $end = new DateTime($this->auction->end_time);
        if($now >= $end && $this->auction->is_active){
            $this->endAuction();
        }
    }
    
    public function createWinner($auction){
        if ($auction->bids->count() > 0 && $auction->bids()->max('amount') >= $auction->reserve_price) {
            $winner = new Winner();
            $winner->user_uuid = Bid::select('user_uuid')
                ->where('auction_uuid', $auction->uuid)
                ->where('amount', $auction->bids()->max('amount'))->pluck('user_uuid')->first();
            $winner->auction_uuid = $auction->uuid;
            $winner->final_amount = $auction->bids()->max('amount');
            $winner->created_at = now();
            $winner->save();
        }
    }

    public function updated(){
       if($this->type == 2){
            $this->bids = $this->auction->getBids();
        }
    }

    public function bidPlaced(){
        $this->updated();
    }

    public function endAuction(){
        $this->isAcceptingBids = false;
        $this->auction->update(['is_active' => false]);
        $this->auction->refresh();
        if ($this->auction->bids->count() > 0 && $this->auction->bids()->max('amount') >= $this->auction->reserve_price) {
            app()->make(AuctionRepositoryInterface::class)->createWinner($this->auction);
        }
    }

    public function itemSelected($selectedItem){
        $selectedItemData = json_decode($selectedItem, true);
        $this->selectedItem = $selectedItem;
        $this->item = $selectedItem;
        $this->selected_uuid = $selectedItemData['uuid'];
        $this->price = $selectedItemData['price'];
        $this->quantity = $selectedItemData['quantity'];
        $this->quantity_sold = $selectedItemData['quantity_sold'];
        foreach (Condition::all() as $condition){
            if ($condition['id'] == $selectedItemData['condition_id']){
                $this->condition = $condition['condition'];
            }
        }
    }

    public function render()
    {
        return view('livewire.full-auction');
    }

    public function getListeners()
    {
        return [
            "echo:auctions.{$this->auction->uuid},BidPlaced" => 'bidPlaced',
        ];
    }
}
