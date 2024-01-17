<div class="table-responsive">
    <table class="table border accordion table-light table-hover">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th scope="col">#</th>
                <th scope="col">Type</th>
                <th scope="col">Active</th>
                <th scope="col">Blocked</th>
                <th scope="col">Title</th>
                <th scope="col">Items</th>
                <th scope="col">Price</th>
                <th scope="col">Reserve</th>
                <th scope="col">Buy-Now</th>
                <th scope="col">Bidders</th>
                <th scope="col">Category</th>
                <th scope="col">End date</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_auctions as $index => $auction)
                <tr @if ($auction->is_blocked)
                    class="table-danger"
                @endif>
                    <th scope="row" data-bs-toggle="collapse" data-bs-target="#r{{$index}}" aria-expanded="false" aria-controls="r{{$index}}">
                        @if (!$auction->is_blocked)
                            <i class="bi bi-chevron-double-down"></i>
                        @endif        
                    </th>
                    <td>
                        {{$index+1}}
                    </td>
                    <td>
                        {{ $auction->type->type }}
                    </td>
                    <td>
                        @if ($auction->is_active )
                            @include('components.yes')
                        @else
                            @include('components.no')
                        @endif
                    </td>
                    <td>
                        @if ($auction->is_blocked )
                            @include('components.yes')
                        @else
                            @include('components.no')
                        @endif
                    </td>
                    <td>
                        <a href="/auction/{{$auction->uuid}}" class="btn" role="button"> {{$auction->title}}</a>
                    </td>
                    <td>
                        {{$auction->items_count}}
                    </td>
                    @if ($auction->type_id === '1')
                        <td>
                            @if ($auction->getMinPriceAttribute() == $auction->getMaxPriceAttribute())
                                {{$auction->getMinPriceAttribute()}}
                            @else
                                {{$auction->getMinPriceAttribute()}} - {{$auction->getMaxPriceAttribute()}}
                            @endif
                        </td>
                    @else
                        <td
                        @if ($auction->secondChance()) 
                            style="color: red;"
                        @endif>
                            {{$auction->price}}
                        </td>
                    @endif
                    @if ($auction->type_id === '1')
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                        <td>
                            -
                        </td>
                    @else
                        <td
                        @if ($auction->secondChance()) 
                            style="color: red;"
                        @endif
                        >
                            @if ($auction->reserve_price)
                                {{$auction->reserve_price }}
                            @else
                                @include('components.no')
                            @endif
                        </td>
                        <td>
                            @if ($auction->buy_now_price)
                                {{$auction->buy_now_price}}
                            @else
                                @include('components.no')
                            @endif
                        </td>
                        <td
                        @if ($auction->endedWithNoBids())
                            style="color: red;"
                        @endif>
                            {{ $auction->bids()->count()}}
                        </td>
                    @endif
                    <td>
                        {{$auction->category->category}}
                    </td>
                    <td>
                        @if ($auction->type_id === '1')
                            -
                        @else 
                            {{$auction->end_time}}
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <div class="btn-group">
                            
                            @if ($auction->secondChance())
                                <a href="{{route('second-chance', ['uuid' => $auction->uuid])}}" class="btn btn-sm btn-dark" onclick="return confirm('Do you want to this anyway?')">Second-chance</a>
                            @elseif ($auction->endedWithNoBids())
                                <a class="btn btn-sm btn-dark " role="button"data-bs-toggle="modal" data-bs-target="#relistModal">Relist</a>
                                @include('auction.components.relistmodal')
                            @else
                                @if (Auth::user()->is_admin || !($auction->is_blocked))
                                    <a href="{{ route('edit-auction', ['uuid' => $auction->uuid, 'route' => 'profile']) }}" class="btn btn-sm btn-dark " role="button">Edit</a>
                                @endif
                            @endif

                            <form action="{{route('delete-auction', ['uuid' => $auction->uuid, 'route' => 'profile'])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @if (!($auction->is_blocked) || Auth::user()->is_admin)
                    <tr class="collapse accordion-collapse" id="r{{$index}}" data-bs-parent=".table">
                        <td colspan="20" class="p-2">
                            @include('auction.components.auctiontableitems', ['auction' => $auction])
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>