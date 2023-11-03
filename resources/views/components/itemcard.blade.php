<div class="card" id="item-card">
    <img @if($item->image != null) src="/images/{{ $item->image }}" @else src="/images/noimage.jpg" @endif class="img-fluid card-img-top" alt="...">
    <div class="card-img-overlay text-end">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
        </svg>
      </div>
    <div class="card-body text-center">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h5 class="card-title">{{$item->title}}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{$item->category}}</h6>
            </li>
            <li class="list-group-item" id="price-bids">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <h6 class="card-subtitle mb-2">Current price:</h6>
                        <h6 class="card-subtitle mb-2">{{$item->current_price}} Eur</h6>
                    </div>
                    <div class="col-md-6 text-center">
                        <h6 class="card-subtitle mb-2">Current bids:</h6>
                        <h6 class="card-subtitle mb-2">{{$item->bidder_count}}</h6>
                    </div>
                </div>
            </li>
            <li class="list-group-item" id="card-footer">
                <div class="row">
                    <div class="col text-center">
                        Ends at:
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        {{$item->end_time}}
                    </div>
                </div>
                <div class="d-grid gap-2 col-3 mx-auto">
                    <a class="btn btn-dark" role="button" href="/item/{{$item->item_uuid}}">BID</a>
                </div>            
            </li>
          </ul>
    </div>
</div>