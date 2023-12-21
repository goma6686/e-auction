<?php

namespace App\Livewire;

use App\Models\Auction;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Algolia\AlgoliaSearch\SearchClient;
use Livewire\Attributes\Url;
use App\Repositories\Interfaces\SearchRepositoryInterface;

class SearchAuctions extends Component
{
    use WithPagination;

    #[Url]
    public $term;
    public $auctions = [];
    public $highlightIndex;
    public $category;
    public $type;
    public $categories;
    protected $searchRepository;

    public function mount($category, $type)
    {
        $this->categories = Category::all();
        $this->category = $category;
        $this->type = $type;
        
        $this->resetlist();
    }

    public function resetlist()
    {
        $this->term  = '';
        $this->auctions = $this->getResult($this->term, 'auctions')['hits'];
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
    }

    public function updatedTerm(){
        $this->auctions = $this->getResult($this->term, 'auctions')['hits'];
    }
    public function render()
    {
        return view('livewire.search-auctions');
    }

    public function getResult($q, $indexString)
    {
        $this->searchRepository = app()->make(SearchRepositoryInterface::class);
        if($this->category === 'all' && $this->type === 'all'){
            $results = $this->searchRepository->searchAuctions($indexString, $q);
        } else if ($this->category !== 'all' && $this->type === 'all'){
            $results = $this->searchRepository->searchAuctionsByCategory($indexString, $this->category, $q);
        } else if ($this->category === 'all' && $this->type !== 'all'){
            $results = $this->searchRepository->searchAuctionsByType($indexString, $this->type, $q);
        } else {
            $results = $this->searchRepository->searchAuctionsByTypeAndCategory($indexString, $this->type, $this->category, $q);
        }
        return $results;
    }
}
