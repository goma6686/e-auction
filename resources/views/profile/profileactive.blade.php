@if(count($active_auctions) > 0)
    <div class="row">
    @foreach ($active_auctions as $auction)
        @include('components.itemcard')
    @endforeach
    </div>
@else
    <h3 style="text-align: center;">No items found :(</h3>
@endif