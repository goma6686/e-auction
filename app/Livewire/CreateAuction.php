<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Condition;
use Livewire\WithFileUploads;

class CreateAuction extends Component
{
    use WithFileUploads;

    public $image;
    public $title;
    public $description;
    public $end_time;
    public $duration;
    public $condition;
    public $is_active;
    public $price;
    public $buy_now_price;
    public $reserve_price;
    public $type;
    public $quantity;

    public $items = [];
    public $conditions;

    public function mount($type){
        $this->type = $type;
        $this->conditions = Condition::all();
        $this->items = [[
            'item_title' => '',
            'condition' => '',
            'image' => '',
            'price' => '',
            'quantity' => '',
            ]];
    }

    public function addItem(){
        $this->items[] = ['item_uuid' => '',
        'item_title' => '',
        'condition' => '',
        'image' => '',
        'price' => '',
        'quantity' => '',
        ];
    }

    public function removeItem($index){
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function render()
    {
        return view('livewire.create-auction');
    }
}
