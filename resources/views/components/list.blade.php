@if(count($list) > 0)
    <div class="row">
    @foreach ($list as $auction)
        @include('components.itemcard')
    @endforeach
    </div>
@else
    <h3 style="text-align: center;">No {{$word}} auctions found :(</h3>
@endif