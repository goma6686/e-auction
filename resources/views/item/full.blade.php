@extends('layouts.main')

@section('content')
<div class="container-xxl">
    <div class="row">
      <div class="col">
        <h3 class="mt-4 text-center">{{ $item->title }}</h3>
        <div class="card p-3 border-dark">
            <img src="https://2.bp.blogspot.com/-muVbmju-gkA/Vir94NirTeI/AAAAAAAAT9c/VoHzHZzQmR4/s580/placeholder-image.jpg" class="card-img-top" style="align-self: center;" width="23">
          <div class="card-body">
            <h3 class="text-center">Description</h3>
            <h6 class="card-footer p-3">{{ $item->description }}</h5>
          </div>
        </div>
      </div>
      <div class="col-7">
      <h3 class="mt-4 text-center">About</h3>
        <div class="card p-3 border-dark">
          <div class="card-body">
            <div class="row">
              <h5 class="row">
                <div class="col-3">Current bids:</div>
                <div class="col-7 text-start" id="p1">{{ $item->bidder_count }}</div>
              </h5></div>
              <h5 class="row">
                <div class="col-3">Category:</div>
                <div class="col-7 text-start">{{ $item->category }}</div>
            </h5>
              <h5 class="row">
                  <div class="col-3">Condition:</div>
                  <div class="col-7 text-start">{{ $item->condition }}</div>
              </h5>
              <h5 class="row">
                  <div class="col-3">Current Price, €:</div>
                  <div class="col-7 text-start" id="price">{{$item->current_price}}</div>
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
                        <input id="bid_amount"  type="number" name="bid_amount" placeholder="Bid amount" step="0.01" min="{{$item->next_price}}">
                        <button id="bid" " class="button btn-sm btn-dark text-right" type="submit">Place bid</button>
                    @else
                        <h5>You can't bid on your own items</h5>
                    @endif
                  @else
                    <h5>You can't bid on items</h5>
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
                <a href="/profile/{{$seller->uuid}}" class="link-dark">{{$seller->username}} ( {{$count}} )</a>
              </div>
            </div>
          </form>
          <h6 class="pt-3 text-center">
            @if (new DateTime($item->end_time) <= new DateTime(\Carbon\Carbon::now()))
                <b id="status">Auction Has Ended</b>
            @elseif (round((strtotime($item->end_time) - time()) / 3600) < 12)
                <div id="timer" class="wrap-countdown time-countdown" data-expire="{{ Carbon\Carbon::parse($item->end_time) }}"></div>
            @else
                {{ (new DateTime($item->end_time))->diff(new DateTime(\Carbon\Carbon::now()))->format("Ends in %dD %hH %iM"); }}
            |   {{ Carbon\Carbon::parse($item->end_time)->format('l H:i') }}
            @endif
          </h6>
          </div>
        </div>
      </div>
    </div>    
</div>
@endsection