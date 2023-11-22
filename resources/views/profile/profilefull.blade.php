<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-active-items-tab" data-bs-toggle="tab" data-bs-target="#nav-active-items" type="button" role="tab" aria-controls="nav-active-items" aria-selected="true">All Auctions</button>
        <button class="nav-link" id="nav-all-items-tab" data-bs-toggle="tab" data-bs-target="#nav-all-items" type="button" role="tab" aria-controls="nav-all-items" aria-selected="false">Edit Auctions</button>
        <button class="nav-link" id="nav-active-bids-tab" data-bs-toggle="tab" data-bs-target="#nav-active-bids" type="button" role="tab" aria-controls="nav-active-bids" aria-selected="false">Active Bids</button>
        <button class="nav-link" id="nav-won-auctions-tab" data-bs-toggle="tab" data-bs-target="#nav-won-auctions" type="button" role="tab" aria-controls="nav-won-auctions" aria-selected="false">Won Auctions</button>
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              Sell
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="{{ route('create-auction', ['type' => 1]) }}">Buy Now</a></li>
                <li><a class="dropdown-item" href="{{ route('create-auction', ['type' => 2]) }}">Auction</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-active-items" role="tabpanel" aria-labelledby="nav-active-items-tab">
        @include('profile.profileactive')
    </div>
    <div class="tab-pane fade" id="nav-all-items" role="tabpanel" aria-labelledby="nav-all-items-tab">
    @if(count($all_auctions) > 0)
        @include('components.auctiontable')
    @else
        <h3 style="text-align: center;">No items found :(</h3>
    @endif
    </div>
    <div class="tab-pane fade" id="nav-active-bids" role="tabpanel" aria-labelledby="nav-active-bids-tab">
        active bids
    </div>
    <div class="tab-pane fade" id="nav-won-auctions" role="tabpanel" aria-labelledby="nav-won-auctions-tab">
        won auctions
    </div>
</div>