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
    public $option;

    public $selectedItem;

    

    public function mount(Auction $auction, $items){
        $this->auction = $auction;
        $this->items = $items;
        $this->item = $this->items[0];
        $this->selectedItem = $this->items[0];
        $this->price = $this->item['current_price'];
        $this->condition = $this->item['condition']['condition'];
    }

    public function itemSelected($selectedItem){
        $selectedItemData = json_decode($selectedItem, true);
        $this->selectedItem = $selectedItem;
        $this->item = $selectedItem;
        $this->price = $selectedItemData['current_price'];
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
