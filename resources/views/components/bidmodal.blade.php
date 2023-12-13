
<div class="modal fade" id="bid" tabindex="-1" aria-labelledby="bid" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered secondary">
    <div class="modal-content">
        <div class="modal-header">
        <h3 class="modal-title" id="bid">Place bid:</h3>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <h6>Current: €{{$auction->price}}</h6>
            <h6>Bids: {{ $auction->bids()->count() }}</h6>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            @for ($i = 0; $i < 3; $i++)
                <form method="post" action="{{route('bid', ['uuid' => $auction->uuid, 'amount' => $bids[$i]])}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button id="price" type="submit" name='action' class="btn btn-dark"> €{{ $bids[$i] }} </button>
                </form>
            @endfor
            </div>
            @if($buy_now_price)
            <form method="post" action="{{route('buy', ['uuid' => $auction->items[0]->uuid])}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <hr>
                <h5>Or Buyout:</h5>
                <div class="d-md-flex justify-content-md-center">
                    <button class="btn btn-dark" type="submit"  name='action'>Buyout for {{$buy_now_price}}€</button>
                </div>
            </form>
            @endif
        </div>
    </div>
    </div>
</div>
