<h3 style="text-align: center;">{{$text}}</h3>
<div class="table-responsive">
    <table class="table accordion table-light table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th scope="col">#</th>
                <th scope="col">Active</th>
                <th scope="col">Type</th>
                <th scope="col">Title</th>
                <th scope="col">Items</th>
                <th scope="col">Price</th>
                <th scope="col">Reserve</th>
                <th scope="col">Buy Now price</th>
                <th scope="col">Bidders</th>
                <th scope="col">Category</th>
                <th scope="col">End date</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_auctions as $index => $auction)
                <tr>
                    <th scope="row" data-bs-toggle="collapse" data-bs-target="#r{{$index}}" aria-expanded="false" aria-controls="r{{$index}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-angle-expand" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5.828 10.172a.5.5 0 0 0-.707 0l-4.096 4.096V11.5a.5.5 0 0 0-1 0v3.975a.5.5 0 0 0 .5.5H4.5a.5.5 0 0 0 0-1H1.732l4.096-4.096a.5.5 0 0 0 0-.707zm4.344-4.344a.5.5 0 0 0 .707 0l4.096-4.096V4.5a.5.5 0 1 0 1 0V.525a.5.5 0 0 0-.5-.5H11.5a.5.5 0 0 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 0 .707z"/>
                        </svg>
                    </th>
                    <td>
                        {{$index}}
                    <td>
                        @if ($auction->is_active == 1) 
                            @include('components.yes')
                        @else 
                            @include('components.no')
                        @endif
                    </td>
                    <td>
                        {{ $auction->type->type }}
                    </td>
                    <td>
                        <a href="/auction/{{$auction->uuid}}" class="btn" role="button"> {{$auction->title}}</a>
                    </td>
                    <td>
                        {{$auction->items_count}}
                    </td>
                    @if ($auction->type_id === '1')
                        @if($auction->buy_price != NULL)
                            <td>
                                {{$auction->buy_price}}
                            </td>
                        @else
                            <td>
                                {{$auction->min_price}} - {{$auction->max_price}}
                            </td>
                        @endif
                    @else
                        <td>
                            {{$auction->price}}
                        </td>
                    @endif
                    <td>
                        @if ($auction->reserve_price == NULL) 
                            @include('components.no')
                        @else
                            {{$auction->reserve_price}}
                        @endif
                    </td>
                    <td>
                        @if ($auction->buy_now_price == NULL) 
                            @include('components.no')
                        @else
                            {{$auction->buy_now_price}}
                        @endif
                    </td>
                    <td>
                        @if ($auction->type_id === '1')
                            @include('components.no')
                        @else
                            {{ $auction->bids()->count()}}
                        @endif
                    </td>
                    <td>
                        {{$auction->category->category}}
                    </td>
                    <td>
                        @if ($auction->end_time == NULL) 
                            @include('components.no')
                        @else 
                            {{$auction->end_time}}    
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <a href="/edit-auction/{{$auction->uuid}}" class="btn btn-sm btn-dark " role="button">Edit</a>
                    </td>
                    <td>
                        <form action="/delete-auction/{{$auction->uuid}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <tr class="collapse accordion-collapse" id="r{{$index}}" data-bs-parent=".table">
                    <td colspan="20">
                        <table class="table table-light table-hover table-striped">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Image</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Condition</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($auction->items as $index => $item)
                              <tr>
                                <th scope="row">{{ $index+1 }}</th>
                                <td>
                                   {{$item->title}}
                                </td>
                                <td>
                                    @if ($item->image != null)
                                        @include('components.yes')
                                    @else
                                        @include('components.no')
                                    @endif
                                </td>
                                <td>
                                    @if($item->price)
                                        {{$item->price}}
                                    @else
                                        @include('components.no')
                                    @endif
                                </td>
                                <td>
                                    {{$item->quantity}}
                                </td>
                                <td>
                                    {{$item->condition->condition}}
                                </td>
                                <td style="text-align: right;">
                                    <a href="/edit-item/{{$item->uuid}}" class="btn btn-sm btn-dark " role="button">Edit</a>
                                </td>
                                <td>
                                    <form action="/delete-item/{{$item->uuid}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
                                    </form>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>