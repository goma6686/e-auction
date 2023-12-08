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
            <h5 class="row">
                <div class="col-3">Condition:</div>
                <div class="col-7 text-start">{{ $condition }}</div>
            </h5>
            @if ($auction->type_id === '1')
                <h5 class="row">
                    <div class="col-3">Price, €:</div>
                    <div class="col-7 text-start" name="price" id="price">{{ $price }}</div>
                </h5>
                <form enctype="multipart/form-data" method="POST" action="{{route('buy', ['uuid' => $selected_uuid])}}">
                    @csrf
            @else
                <h5 class="row">
                    <div class="col-3">
                    @if (!$max_bid)
                        Starting bid, €:
                    </div>
                        <div class="col-7 text-start" name="price" id="price">{{ $auction->price }}</div>
                    @else
                        Current bid, €:
                    </div>
                        <div class="col-7 text-start" name="price" id="price"> {{ $auction->bids()->max('amount') }}</div>
                    @endif
                </h5>
            @endif
            @if ($auction->type_id === '1')
                <h5 class="row">
                    <div class="col-3">Quantity:</div>
                    <div class="col-7">
                    <input id="quantity" type="text" name="quantity" placeholder="1" step="1" min="1" required>
                    <h6>Left: {{ $quantity }}</h6>
                    </div>
                </h5>
            @endif
        @endif
        <hr>
        </div>
        <h5 class="row">
          <div class="col-3">Category:</div>
          <div class="col-7 text-start">{{ $auction->category->category }}</div>
        </h5>
      </div>
        <div class="card-footer form-group row">
          <div class="pt-2 col">
            @guest
            <h5>You can't bid if not logged in</h5>
            @else
              @if(Auth::user()->is_active)
                @if(Auth::user()->uuid != $seller->uuid)
                    @if ($auction->type_id === '1')
                        @include('components.buy')
                    @else
                        @include('components.bid')
                    @endif
                @else
                    <h5>This is your own listing</h5>
                @endif
              @else
                <h5>You are deactivated</h5>
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
            <a href="/profile/{{$seller->uuid}}" class="link-dark">{{$seller->username}} ( {{$auction_count}} )</a>
          </div>
        </div>
    </form>
    <h6 class="pt-3 text-center">
      @if (new DateTime($auction->end_time) <= new DateTime(\Carbon\Carbon::now()))
          <b id="status">Auction Has Ended</b>
      @elseif (round((strtotime($auction->end_time) - time()) / 3600) < 12)
          <div id="timer" class="wrap-countdown time-countdown" data-expire="{{ Carbon\Carbon::parse($auction->end_time) }}"></div>
      @else
          {{ (new DateTime($auction->end_time))->diff(new DateTime(\Carbon\Carbon::now()))->format("Ends in %dD %hH %iM"); }}
      |   {{ Carbon\Carbon::parse($auction->end_time)->format('l H:i') }}
      @endif
    </h6>
    @include('components.sessionmessage')
    </div>
  </div>
