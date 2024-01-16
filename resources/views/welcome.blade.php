@extends('layouts.main')

@section('content'){{--
    <div id="myCarousel" class="carousel slide multi-item-carousel" data-bs-ride="carousel"  data-bs-interval="false">
        <div class="carousel-inner ">
            @foreach ($categories->chunk(5) as $key => $category)
            <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                <div class="row d-flex justify-content-center">
                    @foreach ($category as $c)
                        <div class="col-1">
                            @include('components.categorycard', ['category' => $c])
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span><<</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span>>></span>
            </button>
        </div>
    </div>--}}
    <h2>Featured Items</h2>
    <div class="row d-flex justify-content-center">
        @foreach ($auction_items as $auction)
            @include('auction.components.itemcard')
        @endforeach
    </div>
    <div class="text-center">
        <a class="btn btn-dark" id="see-all" href="{{ route('home') }}">SEE ALL</a>
    </div>
@endsection