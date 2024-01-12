@foreach (Auth::user()->getWaitingForPaymentAuctions() as $auction)
<div class="card" id="item-card">
    <div class="card-header text-center">
        <h6 class="mb-2 text-muted">
            {{$auction->category->category}}
        </h6>
    <h5>
        {{$auction->title }}
    </h5>
    </div>
    <div class="card-body">
    <ul class="btn-group-vertical list-group" role="group" >
        @foreach ($auction->items as $index => $item)
            <button class="btn text-start dropdown-toggle" type="button"   id="dropdownMenuButton{{$index}}" data-bs-toggle="dropdown" aria-expanded="false">
                {{$item->title}}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$index}}">
                <li class="dropdown-item">
                   Condition: [{{$item->condition->condition}}]
                <img class="img-responsive rounded d-block " id="list-image"  @if (isset($auction['items'][$index]['image'])) src="/images/items/{{ $auction['items'][$index]['image'] }}" @else src="/images/noimage.jpg" @endif>
                </li>
            </ul>
        @endforeach
    </ul>
    <hr>
    <div class="text-center">
        <dl>
            <dt>WINNER:</dt>
            <a href="/profile/{{$auction->winner->uuid}}" class="link-dark">
            <dd>
                {{$auction->winner->username}},
            </dd>
            <dd>
                {{$auction->winner->email}}
            </dd>
        </a>
            <dt>PRICE:</dt>
            <dd>{{$auction->price}}Eur</dd>
        </dl>
    </div>
    </div>
    <div class="card-footer text-muted ">
        
        <div class="d-grid gap-2 col-6 mx-auto">
            <form action="{{route('cancel-auction', ['uuid' => $auction->uuid])}}" method="POST">
                @csrf
                <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to cancel this auction?')">CANCEL</button>
            </form>
        </div> 
    </div>
</div>
@endforeach