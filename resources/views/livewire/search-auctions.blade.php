<div>
    <div class="relative p-2">
        <input
            type="text"
            class="form-input w-full"
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
                @include('components.itemcard')
                @endforeach
            </div>
            @else
                <div class="h-100">
                    No results!
                </div>
            @endif
        {{--
        @if(!empty($term))
                @if(!empty($auctions))
                <div class="row">
                    @foreach ($auctions as $auction)
                    @include('components.itemcard')
                    @endforeach
                    </div>
                @endif
        @else
            <div class="row">
            @foreach ($auctions as $auction)
            @include('components.itemcard')
            @endforeach
            </div>
        @endif--}}
    </div>
</div>