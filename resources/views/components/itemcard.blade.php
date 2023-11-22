<div class="card" id="item-card">
    <div class="h-100 text-center">
        <div class="card-img-overlay h-50 text-end">
            @include('components.heart')    
        </div>
        <img id="item-image" @if($auction->items[0]->image != null) src="/images/{{ $auction->items[0]->image }}" @else src="/images/noimage.jpg" @endif class="card-img-top mx-auto d-block" alt="{{$auction->title}}">
    </div>
    
    <div class="card-body text-center">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h5 class="card-title">{{$auction->title}}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$auction->category->category}}</h6>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col">
                        @if ($auction->price != null)
                            <h6 class="card-subtitle mb-2">Price:</h6>
                            <h6 class="card-subtitle mb-2">{{$auction->price}} Eur</h6>
                        @else
                            <h6 class="card-subtitle mb-2">From:</h6>
                            <h6 class="card-subtitle mb-2">{{$auction->min_price}} Eur</h6>
                        @endif
                    </div>
                    @if ($auction->type_id === '2')
                        <div class="col-md-6 text-center">
                            <h6 class="card-subtitle mb-2">Current bids:</h6>
                            <h6 class="card-subtitle mb-2">{{$auction->bidder_count}}</h6>
                        </div>
                    @endif
                </div>
            </li>
          </ul>
    </div>
    <div class="card-footer text-muted">
        @if ($auction->end_time != null)
            <div class="row">
                <div class="col text-center">
                    Ends at:
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    {{$auction->end_time}}
                </div>
            </div>
        @endif
        <div class="d-grid gap-2 col-3 mx-auto">
            <a class="btn btn-dark" role="button" href="/auction/{{ $auction->uuid }}">BID</a>
        </div> 
    </div>
</div>