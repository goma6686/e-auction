<div>
    <input
        type="text"
        class="form-input w-100"
        placeholder="Search Auctions..."
        wire:model.live="query"
    />
    @if (!empty($auctions))
    <div class="row">
        @foreach ($auctions as $auction)
            @include('auction.components.itemcard')
        @endforeach
    @else
        No results!
    @endif
    </div>
</div>