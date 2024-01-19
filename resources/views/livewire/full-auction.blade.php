<div class="card p-3 border-dark">
    <div class="card-body">
      <div class="row">
        @if ($auction->items_count === 1)
            <h5 class="row">
                <div class="col-3">Item:</div>
                <div class="col-7 text-start"> {{ $auction->items[0]->title }}</div>
            </h5>
            <h5 class="row">
                <div class="col-3">Condition:</div>
                <div class="col-7 text-start">{{ $auction->items[0]->condition->condition }}</div>
            </h5>
            <h5 class="row">
                <div class="col-3"> Price, €:</div>
                <div class="col-7 text-start" id="price">{{$auction->items[0]->price}}</div>
            </h5>
            @if ($auction->type_id === '1')
            <h5 class="row">
                <div class="col-3">Quantity:</div>
                <div class="col-7">
                    <input id="quantity"  type="number" name="quantity" placeholder="1" step="1" min="1">
                    <h6>Left: {{ $auction->items[0]->quantity }}</h6>
                </div>
            </h5>
            @endif
        @else
            <h5 class="row">
                <div class="text-start">
                    <label for="selectedItem">
                        @if ($auction->type_id === '1')
                        Select an item to buy:
                        @else
                        Items in listing:
                        @endif
                    </label>
                    <select class="form-control"
                        wire:model="selectedItem"
                        wire:change="itemSelected($event.target.value)"
                        required>
                        @foreach($items as $item)
                        <option
                            value="{{ $item }}">
                                {{$item->title}}
                            </option>
                    @endforeach
                    </select>
                </div>
            </h5>
            <div class="row">
                <h5 class="col-lg-3">Condition:</h5>
                <h6 class="col-lg-7 text-start">{{ $condition }}</h6>
            </div>
            @if ($auction->type_id === '1')
                <div class="row">
                    <h5 class="col-lg-3">Price, €:</h5>
                    <h6 class="col-lg-7 text-start" name="price">{{ $price }}</h6>
                </div>
                <form enctype="multipart/form-data" method="POST" action="{{route('buy', ['uuid' => $selected_uuid])}}">
                    @csrf
            @else
                <div class="row">
                    <h5 class="col-lg-3">
                    @if ($auction->bids->count() === 0)
                        Starting bid, €:
                    @else
                        Current bid, €:
                    @endif
                    </h5>
                    <h6 class="col-7 text-start" name="price"> {{ $auction->bids()->max('amount') ?? $auction->price }}</h6>
                </div>
            @endif
            @if ($auction->type_id === '1')
                <h5 class="row">
                    <div class="col-3">Quantity:</div>
                    <div class="col-7">
                    <h6 style="color: red;">{{ $quantity_sold }}</h6>
                    <input id="quantity" type="text" name="quantity" placeholder="1" step="1" min="1" required>
                    <h6>{{ $quantity }} </h6>
                    
                    </div>
                </h5>
            @endif
        @endif
        <hr>
        </div>
        <div class="row">
          <h5 class="col-lg-3">Category:</h5>
          <h6 class="col-lg-7 text-start">{{ $auction->category->category }}</h6>
        </div>
      </div>
        <div class="card-footer form-group row">
          <div class="pt-2 col">
            @guest
            <h6>You can't bid if not logged in</h6>
            @else
              @if(Auth::user()->is_active)
                @if(Auth::user() != $auction->getAuctionSeller())
                    @if ($auction->type_id === '1')
                        @include('auction.components.buy')
                    @else
                        @include('auction.components.bid')
                    @endif
                @else
                    <h6>This is your own listing</h6>
                @endif
              @else
                <h6>You are deactivated</h6>
              @endif
            @endguest
          </div>
          <div class="col text-end">
            <h6>Seller:</h6>
            <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
              </svg>
            </span> 
            <a href="/profile/{{$auction->getAuctionSeller()->uuid}}" class="link-dark">{{$auction->getAuctionSeller()->username}} ( {{$auction_count}} )</a>
          </div>
        </div>
    </form>
        <h6 class="pt-3 text-center">
            @isset ($isAcceptingBids)
                @if (round((strtotime($auction->end_time) - time()) / 3600) < 12)
                    <div id="timer" class="wrap-countdown time-countdown" 
                    data-expire="{{ Carbon\Carbon::parse($auction->end_time) }}"></div>
                @else
                    {{ $auction->end_time->toDayDateTimeString() }}
                @endif
            @else
                <b id="status">Auction Has Ended</b>
            @endisset
        </h6>
    @include('components.sessionmessage')
    </div>
  </div>
@if ($isAcceptingBids && $auction->type_id === '2')
    @include('scripts.timer')
@endif

