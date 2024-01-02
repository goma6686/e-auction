<div class="card" id="item-card">
    <div class="h-100 text-center">
        @auth
        @if (!Auth::user()->auctions->contains('uuid', $auction['uuid']))
                <button class="@if (Auth::user()->favourites->contains('auction_uuid',  $auction['uuid'])) 
                    icon-active @else icon-not-active @endif toggleFavourite btn btn-lg" data-item="{{  $auction['uuid'] }}">
                    <i class="bi bi-heart-fill" ></i>
                </button>
            @endif
        @endauth
        <img id="item-image"
         @if (isset($auction['items'][0]['image']))
             src="/images/items/{{ $auction['items'][0]['image'] }}"
            @elseif (isset($auction['images'][0]))
            src="/images/items/{{ $auction['images'][0] }}"
            @else
            src="/images/noimage.jpg"
         @endif
         class="card-img-top mx-auto d-block" alt="{{$auction['title']}}">
        </div>
    
    <div class="card-body text-center">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
            <h5 class="card-title"
            @auth
                @isset($auction['highest_bidder'])
                    @if ($auction['highest_bidder'] !== Auth::user()->uuid)
                        style="color: red;"
                    @else
                        style="color: green;"
                    @endif
                @endisset
            @endauth
            >
            {{$auction['title'] }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    
                    @foreach ($categories as $categ)
                    @if ($categ['id'] == $auction['category_id'])
                        {{$categ['category']}}
                    @endif
                @endforeach
                    
                </h6>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col">
                        @if ($auction['type_id'] === '1')
                            <h6 class="card-subtitle mb-2">From:</h6>
                            <h6 class="card-subtitle mb-2">{{$auction['items_min_price'] ?? ''}} Eur</h6>
                        @else
                            <h6 class="card-subtitle mb-2">Price:</h6>
                            <h6 class="card-subtitle mb-2">{{$auction['price']}} Eur</h6>
                        @endif
                    </div>
                    @if ($auction['type_id'] === '2')
                        <div class="col-md-6 text-center">
                            @if($auction->getAuctionWinner())
                                <h6 class="card-subtitle mb-2">Winner:</h6>
                                <a href="/profile/{{$auction->getAuctionWinner()->uuid}}" class="card-subtitle mb-2 link-dark">{{$auction->getAuctionWinner()->username}}</a>
                            @else
                                <h6 class="card-subtitle mb-2">Current bids: </h6>
                                <h6 class="card-subtitle mb-2">{{ $auction['bids_count'] ?? ''}}</h6>
                            @endif
                        </div>
                    @endif
                </div>
            </li>
          </ul>
    </div>
    <div class="card-footer text-muted">
        @if ($auction['end_time'] != null)
            <div class="row">
                <div class="col text-center">
                    Ends at:
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    {{  $auction['end_time'] }}
                </div>
            </div>
        @endif
        <div class="d-grid gap-2 col-3 mx-auto">
            <a class="btn btn-dark" role="button" href="/auction/{{ $auction['uuid'] }}">
                @if ($auction['type_id'] === '2')
                BID
                @else
                BUY
                @endif
            </a>
        </div> 
    </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/favourites.js')}}"></script>
@endsection