<?php

namespace App\Livewire;

use App\Models\Auction;
use App\Models\Condition;
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

    public function mount(Auction $auction, $items, $seller, $type, $auction_count, $bids, $buy_now_price, $max_bid){
        $this->max_bid = $max_bid;
        $this->buy_now_price = $buy_now_price;
        $this->bids = $bids;
        $this->auction_count = $auction_count;
        $this->seller = $seller;
        $this->type = $type;
        $this->auction = $auction;
        $this->items = $items;
        $this->item = $this->items[0];
        $this->selectedItem = $this->items[0];
        $this->selected_uuid = $this->items[0]['uuid'];
        $this->price = $this->item['price'];
        $this->condition = $this->item['condition']['condition'];
        $this->quantity = $this->item['quantity'];
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
}
