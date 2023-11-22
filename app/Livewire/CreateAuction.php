<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Category;
use App\Models\Condition;
use Livewire\WithFileUploads;

class CreateAuction extends Component
{
    use WithFileUploads;

    public $image;

    public $categories;
    public $title;
    public $description;
    public $end_time;
    public $category;
    public $condition;
    public $is_active;
    public $price;
    public $buy_now_price;
    public $reserve_price;
    public $type;
    public $quantity;

    public $items = [];
    public $conditions;

    protected $rules = [
        'title' => 'required',
        'description' => 'required|min:3',
        'end_time' => 'required|date|after:today',
        'category' => 'required|exists:categories,id',
        'condition' => 'required|exists:conditions,id',
        'price' => 'required|numeric|min:0.01',
    ];

    public function mount($type){
        $this->categories = Category::all();
        $this->type = $type;
        $this->conditions = Condition::all();
        $this->items = [[
            'item_title' => '',
            'condition' => '',
            'image' => '',
            'price' => '',
            'reserve_price' => '',
            'quantity' => '',
            ]];
    }

    public function addItem(){
        $this->items[] = ['item_uuid' => '',
        'item_title' => '',
        'condition' => '',
        'image' => '',
        'price' => '',
        'reserve_price' => '',
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
