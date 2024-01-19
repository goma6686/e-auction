<div>
<div class="row m-2 ">
    <input
    type="text"
    class="form-input w-100"
    placeholder="Search Auctions..."
    wire:model.live="query"
/>
</div>
<div class="col">
    <div wire:loading> 
        Searching ...
    </div>
    @if (!empty($auctions))
    <div class="row p-2--md p-2--xl p-2--xxl">
        @foreach ($auctions as $auction)
        <div class="col d-flex justify-content-evenly">
            @include('auction.components.itemcard')
        </div>
        @endforeach
    @else
        No results!
    </div>
    @endif
</div>
</div>