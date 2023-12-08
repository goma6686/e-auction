@extends('layouts.main')

@section('content')
<div class="container-xxl">
  <h2 class="mt-2 text-center"> {{$auction->title}} </h2>
  <div class="row">

    <div class="col">
      <div class="card p-3 border-dark">
        @auth
          @if (!Auth::user()->auctions->contains('uuid', $auction->uuid))
            <button class="@if (Auth::user()->favourites->contains('auction_uuid', $auction->uuid)) 
                icon-active @else icon-not-active @endif toggleFavourite btn btn-lg" data-item="{{ $auction->uuid }}">
                <i class="bi bi-heart-fill" ></i>
            </button>
          @endif
        @endauth
          @include('components.carousel')
          <div class="card-body">
            <h3 class="text-center">Description</h3>
            <h6 class="card-footer p-3">{{ $auction->description }}</h5>
        </div>
      </div>
    </div>

    <div class="col-7">
      @livewire('choose-item', ['auction' => $auction->uuid, 'items' => $auction->items, 'type' => $auction->type_id, 'seller' => $seller, 'auction_count' => $auction_count, 'bids' => $bids, 'buy_now_price' => $buy_now_price, 'max_bid' => $max_bid])
    </div>
  </div>    
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/favourites.js')}}"></script>
@endsection