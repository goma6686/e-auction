<div class="container mt-2">
    <div class="container px-4 px-lg-5 mt-5">
    @if(count($active_items) > 0)
        <div class="row gx-3 gy-3 row-cols-2 row-cols-md-3 row-cols-xl-3">
        @foreach ($active_items as $item)
            @include('components.itemcard')
        @endforeach
        </div>
    @else
        <h3 style="text-align: center;">No items found :(</h3>
    @endif
    </div>
</div>