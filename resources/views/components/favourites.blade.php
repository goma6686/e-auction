@if(count($favourited) > 0)
    <div class="row">
    @foreach ($favourited as $auction)
        @include('components.itemcard')
    @endforeach
    </div>
@else
    <h3 style="text-align: center;">No favourited auctions found :(</h3>
@endif