<?php

namespace App\Livewire;

use App\Events\EndAuction;
use App\Models\Auction;
use App\Models\Condition;
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
    public $selectedItem;
    public $seller;
    public $type;
    public $auction_count;
    public $selected_uuid;
    public $bids;
    public $buy_now_price;
    public $max_bid;

    public $isAcceptingBids;
    public $showBidNotification = false;

    public function mount(Auction $auction, $seller, $bids){
        $this->max_bid = $auction->bids()->max('amount');
        $this->buy_now_price = $auction->buy_now_price;
        $this->bids = $bids;
        $this->auction_count = $seller->auctions->where('is_active', true)->count();
        $this->seller = $seller;
        $this->type = $auction->type_id;
        $this->auction = $auction;
        $this->items = $auction->items;
        $this->item = $this->items[0];
        $this->selectedItem = $this->items[0];
        $this->selected_uuid = $this->items[0]['uuid'];
        $this->price = $this->item['price'];
        $this->condition = $this->item['condition']['condition'];
        $this->quantity = $this->item['quantity'];
        $this->isAcceptingBids = $this->auction->is_active;

        $now = new DateTime(\Carbon\Carbon::now());
        $end = new DateTime($this->auction->end_time);
        if($now >= $end && $this->auction->is_active){
            EndAuction::dispatch($auction);
        }
    }

    public function bidPlaced(){
        $this->showBidNotification = true;
    }

    public function endAuction(){
        $this->isAcceptingBids = false;
    }

    public function itemSelected($selectedItem){
        $selectedItemData = json_decode($selectedItem, true);
        $this->selectedItem = $selectedItem;
        $this->item = $selectedItem;
        $this->selected_uuid = $selectedItemData['uuid'];
        $this->price = $selectedItemData['price'];
        $this->quantity = $selectedItemData['quantity'];
        foreach (Condition::all() as $condition){
            if ($condition['id'] == $selectedItemData['condition_id']){
                $this->condition = $condition['condition'];
            }
        }
    }

    public function render()
    {
        return view('livewire.choose-item');
    }

    public function getListeners()
    {
        return [
            "echo:auctions.{$this->auction->uuid},BidPlaced" => 'bidPlaced',
            "end-auction.{$this->auction->uuid},EndAuction" => 'endAuction',
        ];
    }
}
