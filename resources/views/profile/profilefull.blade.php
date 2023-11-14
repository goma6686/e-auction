<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link active" id="nav-active-items-tab" data-bs-toggle="tab" data-bs-target="#nav-active-items" type="button" role="tab" aria-controls="nav-active-items" aria-selected="true">All Auctions</button>
        <button class="nav-link" id="nav-all-items-tab" data-bs-toggle="tab" data-bs-target="#nav-all-items" type="button" role="tab" aria-controls="nav-all-items" aria-selected="false">Edit Auctions</button>
        <button class="nav-link" id="nav-active-bids-tab" data-bs-toggle="tab" data-bs-target="#nav-active-bids" type="button" role="tab" aria-controls="nav-active-bids" aria-selected="false">Active Bids</button>
        <button class="nav-link" id="nav-won-auctions-tab" data-bs-toggle="tab" data-bs-target="#nav-won-auctions" type="button" role="tab" aria-controls="nav-won-auctions" aria-selected="false">Won Auctions</button>
        <a class="btn" role="button" href="{{ route('create-auction') }}">Add Auction</a>
    </div>
</nav>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-active-items" role="tabpanel" aria-labelledby="nav-active-items-tab">
        @include('profile.profileactive')
    </div>
    <div class="tab-pane fade" id="nav-all-items" role="tabpanel" aria-labelledby="nav-all-items-tab">
        <div class="container mt-2">
            <div class="container px-4 px-lg-5 mt-5">
            @if(count($all_auctions) > 0)
                @include('auction.auctiontable')
            @else
                <h3 style="text-align: center;">No items found :(</h3>
            @endif
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-active-bids" role="tabpanel" aria-labelledby="nav-active-bids-tab">
        active bids
    </div>
    <div class="tab-pane fade" id="nav-won-auctions" role="tabpanel" aria-labelledby="nav-won-auctions-tab">
        won auctions
    </div>
</div>