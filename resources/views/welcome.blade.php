@extends('layouts.main')

@section('content')
    <div id="myCarousel" class="carousel slide multi-item-carousel" data-bs-ride="carousel">
        
        <div class="carousel-inner">
            @foreach ($categories->chunk(4) as $key => $category)
            <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                <div class="row" id="categories">
                    @foreach ($category as $item)
                        <div class="col-md-2">
                            @include('components.categorycard', ['category' => $item])
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
            <span><<</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
            <span>>></span>
        </button>
    </div>
    <h2>Featured Items</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($auction_items as $item)
            @include('components.itemcard')
        @endforeach
    </div>
    <button type="button" id="see-all" class="btn btn-outline-dark">SEE ALL</button>
@endsection