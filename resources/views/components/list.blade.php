@if(count($list) > 0)
    <div class="row">
    @foreach ($list as $auction)
        @include('auction.components.itemcard')
    @endforeach
    </div>
@else
    <h3 style="text-align: center;">No {{$word}} auctions found :(</h3>
@endif