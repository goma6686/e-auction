<!DOCTYPE html>
@include('layouts.header')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @include('layouts.topbar')
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-6">
                    @foreach ($categories as $category)
                        @include('components.categorycard')
                    @endforeach
                </div>
                <h2>Featured Items</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach ($auction_items as $item)
                        @include('components.itemcard')
                    @endforeach
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>
