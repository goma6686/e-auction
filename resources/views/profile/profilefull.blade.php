<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="active-tab" href="#active" data-bs-toggle="tab" data-bs-target="#active" role="tab" aria-controls="active" aria-selected="true">All Auctions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="all-tab" href="#all" data-bs-toggle="tab" data-bs-target="#all"role="tab" aria-controls="all" aria-selected="false">Edit Auctions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="bids-tab" href="#bids" data-bs-toggle="tab" data-bs-target="#bids" role="tab" aria-controls="bids" aria-selected="false">Active Bids</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="won-tab" href="#active" data-bs-toggle="tab" data-bs-target="#won" role="tab" aria-controls="won" aria-selected="false">Won Auctions</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="favourite-tab" href="#favourite" data-bs-toggle="tab" data-bs-target="#favourite" role="tab" aria-controls="favourite" aria-selected="false">Favourite Auctions</a>
    </li>
    <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sell
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('create-auction', ['type' => 1]) }}">Buy Now</a></li>
            <li><a class="dropdown-item" href="{{ route('create-auction', ['type' => 2]) }}">Auction</a></li>
        </ul>
    </div>
</ul>

<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane tab fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
        @include('profile.profileactive')
    </div>
    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
    @if(count($all_auctions) > 0)
        @include('components.sessionmessage')
        @include('components.auctiontable')
    @else
        <h3 style="text-align: center;">No items found :(</h3>
    @endif
    </div>
    <div class="tab-pane fade" id="bids" role="tabpanel" aria-labelledby="bids-tab">
        active bids
    </div>
    <div class="tab-pane fade" id="won" role="tabpanel" aria-labelledby="won-tab">
        won auctions
    </div>
    <div class="tab-pane fade" id="favourite" role="tabpanel" aria-labelledby="favourite-tab">
        @include('components.favourites')
    </div>
</div>
<script type="text/javascript" src="{{asset('js/profile-tabs.js')}}"></script>