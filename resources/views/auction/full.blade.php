@extends('layouts.main')

@section('content')
<div class="container-xxl" id="large">
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
      @livewire('choose-item', ['auction' => $auction->uuid, 'bids' => $bids])
    </div>
  </div> 
  {{--
    Below is for smaller screens 
  --}}

  <div class="container" id="below-large">
    <h3 class="mt-2 text-center"> {{$auction->title}} </h3>
    <div class="row">
      <div class="card p-3 border-dark">
        @auth
          @if (!Auth::user()->auctions->contains('uuid', $auction->uuid))
            <button class="@if (Auth::user()->favourites->contains('auction_uuid', $auction->uuid)) 
                icon-active @else icon-not-active @endif toggleFavourite btn btn-lg" data-item="{{ $auction->uuid }}">
                <i class="bi bi-heart-fill" ></i>
            </button>
          @endif
        @endauth
          <a data-bs-toggle="modal" href="#itemModal" role="button">
            <img
         @if (isset($auction['items'][0]['image']))
             src="/images/items/{{ $auction['items'][0]['image'] }}"
            @elseif (isset($auction['images'][0]))
            src="/images/items/{{ $auction['images'][0] }}"
            @else
            src="/images/noimage.jpg"
         @endif
         class="card-img-top mx-auto d-block img-fluid" alt="{{$auction['title']}}">
         <div class="carousel-indicators">
          @for ($i = 0; $i < $auction->items_count; $i++)
            <button type="button" data-bs-target="#item" data-bs-slide-to="{{$i}}" class="{{$i === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{$i}}"></button>
          @endfor
        </div>
          </a>
          <div class="modal fade" id="itemModal" aria-hidden="true" aria-labelledby="itemModalLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="itemModalLabel">{{$auction->items_count}} Items</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <ul class="list-group">
                    @foreach ($auction->items as $index => $item)
                    <li class="list-group-item">
                      <h5>{{$item->title}}</h5>
                      <h6>[{{$item->condition->condition}}]</h6>
                      <img id="item-image" @if($item->image != null) src="/images/items/{{ $item->image }}" @else src="/images/noimage.jpg" @endif class="card-img-top img-fluid ratio">
                    </li>
                    @endforeach
                  </ul>
                  
                </div>
              </div>
            </div>
          </div>
          <h5 class="text-center ">Description</h5>
          <p class="">{{ $auction->description }}</p>
        </div>
    </div>
    <div class="row mt-2">
      @livewire('choose-item', ['auction' => $auction->uuid, 'bids' => $bids])
    </div>
  </div>     
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/favourites.js')}}"></script>
@include('scripts.pusher')
@endsection