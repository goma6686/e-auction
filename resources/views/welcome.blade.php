<!DOCTYPE html>
@include('layouts.header')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body class="antialiased">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @include('layouts.topbar')
            <div class="container">
                <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
                    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                        <span><<</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                        <span>>></span>
                    </button>
                    <div class="carousel-inner">
                        @foreach ($categories->chunk(4) as $key => $chunk)
                            <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                                <div class="row" id="categories">
                                    @foreach ($chunk as $category)
                                    <div class="col-md-2">
                                        @include('components.categorycard', ['category' => $category])
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                  
                <h2>Featured Items</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($auction_items as $item)
                        @include('components.itemcard')
                    @endforeach
                </div>

                <button type="button" id="see-all" class="btn btn-outline-dark">SEE ALL</button>
            </div>
            
    </body>
</html>
