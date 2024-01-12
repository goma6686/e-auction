<div>
    <div class="relative p-2">
        <input
            type="text"
            class="form-input w-100"
            placeholder="Search Auctions..."
            wire:model.live="term"
            wire:keydown.escape="resetlist"
            wire:keydown.tab="resetlist"
            wire:keydown.arrow-up="decrementHighlight"
            wire:keydown.arrow-down="incrementHighlight"
            wire:keydown.enter="selectAuction"
        />
            @if (!empty($auctions))
            <div class="row">
                @foreach ($auctions as $auction)
                @include('auction.components.itemcard')
                @endforeach
            </div>
            @else
                <div class="row h-75">
                    No results!
                </div>
            @endif
    </div>
</div>