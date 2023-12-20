<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Auction;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class SearchAuctions extends Component
{
    use WithPagination;

    #[Url]
    public $term;
    public $auctions;
    public $highlightIndex;

    public function mount()
    {
        $this->resetlist();
    }

    public function resetlist()
    {
        $this->term  = '';
        $this->auctions = Auction::all();
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->auctions) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->auctions) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectAuction()
    {
        $auction = $this->auctions[$this->highlightIndex] ?? null;
       /* if ($auction) {
             $this->redirect(route('show-auction', $auction->uuid));
         }*/
    }

    public function updatedTerm(){
        $this->auctions = Auction::search($this->term)->get() ?? Auction::all();
    }
    public function render()
    {
        return view('livewire.search-auctions');
    }
}
