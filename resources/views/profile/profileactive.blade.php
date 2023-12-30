@if(count($auctions) > 0)
    <div class="row">
    @foreach ($auctions as $auction)
        @include('auction.components.itemcard')
    @endforeach
    </div>
@else
    <h3 style="text-align: center;">No items found :(</h3>
@endif