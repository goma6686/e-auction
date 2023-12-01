@extends('layouts.main')

@section('content')
<div class="container-xxl">
  <h2 class="mt-2 text-center"> {{$auction->title}} </h2>
  <div class="row">

    <div class="col">
      <div class="card p-3 border-dark">
        @auth
            <button class="@if (Auth::user()->favourites->contains('auction_uuid', $auction->uuid)) 
                icon-active @else icon-not-active @endif toggleFavourite btn btn-lg" data-item="{{ $auction->uuid }}">
                <i class="bi bi-heart-fill" ></i>
            </button>
        @endauth
          @include('components.carousel')
          <div class="card-body">
            <h3 class="text-center">Description</h3>
            <h6 class="card-footer p-3">{{ $auction->description }}</h5>
        </div>
      </div>
    </div>

    <div class="col-7">
      <h3 class="mt-2 text-center">About</h3>
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
                @livewire('choose-item', ['auction' => $auction->uuid, 'items' => $auction->items])
              @endif
              <hr>
              </div>
              <h5 class="row">
                <div class="col-3">Category:</div>
                <div class="col-7 text-start">{{ $auction->category->category }}</div>
              </h5>
            </div>
          <form enctype="multipart/form-data" method="POST" action="#">
            @csrf
            <div class="card-footer form-group row">
              <div class="pt-2 col">
                @guest
                <h5>You can't bid if not logged in</h5>
                @else
                  @if(Auth::user()->is_active)
                    @if(Auth::user()->uuid != $seller->uuid)
                        <h5>Place a bid, €:</h5>
                        <input id="bid_amount"  type="number" name="bid_amount" placeholder="Bid amount" step="0.01" min="{{$auction->next_price}}">
                        <button id="bid" class="button btn-sm btn-dark text-right" type="submit">Place bid</button>
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
          </div>
        </div>
    </div>
  </div>    
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/favourites.js')}}"></script>
@endsection