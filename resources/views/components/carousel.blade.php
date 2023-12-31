<div id="item" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      @for ($i = 0; $i < $auction->items_count; $i++)
        <button type="button" data-bs-target="#item" data-bs-slide-to="{{$i}}" class="{{$i === 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{$i}}"></button>
      @endfor
    </div>
    <div class="carousel-inner">
        @foreach ($auction->items as $index => $item)
        <div class="carousel-item {{$index === 0 ? 'active' : '' }}">
            <img id="item-image" @if($item->image != null) src="/images/items/{{ $item->image }}" @else src="/images/noimage.jpg" @endif class="card-img-top ratio">
            <div class="carousel-caption d-none d-md-block">
                <h5>{{$item->title}}</h5>
            </div>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#item" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#item" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>