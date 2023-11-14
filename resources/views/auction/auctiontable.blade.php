<table class="table table-responsive table-light table-hover  table-striped">
    <thead>
        <tr>
            <th></th>
            <th scope="col">#</th>
            <th scope="col">Active</th>
            <th scope="col">Title</th>
            <th scope="col">Items</th>
            <th scope="col">Price</th>
            <th scope="col">Bidders</th>
            <th scope="col">Category</th>
            <th scope="col">Condition</th>
            <th scope="col">End date</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @php
            $counter = 0;
        @endphp
        @foreach ($all_auctions as $auction)
            @php
            $counter++;
            @endphp
            <tr scope="row" data-toggle="collapse" data-target="#demo1" class="accordion-toggle">
                <td><button class="btn btn-default btn-xs"><span class="glyphicon glyphicon-eye-open"></span></button></td>
                <th>{{$counter}}</th>
                <td>
                    @if ($auction->is_active == 1) 
                        @include('components.yes')
                    @else 
                        @include('components.no')
                    @endif
                </td>
                <td>
                    <a href="/auction/{{$auction->uuid}}" class="btn" role="button"> {{$auction->title}}</a>
                </td>
                <td>
                    {{$auction->count}}
                </td>
                @if ($auction->count === 1)
                    <td>
                        {{$auction->price}}
                    </td>
                @else
                    <td>
                        {{$auction->min_price}} - {{$auction->max_price}}
                    </td>
                @endif
                <td>
                    {{$auction->bidder_count}}
                </td>
                <td>
                    {{$auction->category->category}}
                </td>
                <td>
                    {{$auction->condition}}
                </td>
                <td>
                    {{$auction->end_time}}
                </td>
                <td style="text-align: right;">
                    <a href="/edit-item/{{$auction->uuid}}" class="btn btn-sm btn-dark " role="button">Edit</a>
                </td>
                <td>
                    <form action="/delete-auction/{{$auction->uuid}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
            @foreach ($auction->items as $item)
                <tr>
                    <td colspan="12" class="hiddenRow">
                        <div class="accordian-body collapse" id="demo1"> 
                        <table class="table table-striped">
                            <thead>
                                <tr class="info">
                                    <th scope="col">Title</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Condition</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-toggle="collapse"  class="accordion-toggle" data-target="#demo10">
                                    <td colspan="12" class="hiddenRow">
                                        <a href="/item/{{$item->uuid}}" class="btn" role="button"> {{$item->title}}</a>
                                    </td>
                                    <td>
                                        @if ($item->image != NULL) 
                                            @include('components.yes')
                                        @else 
                                            @include('components.no')
                                        @endif
                                    </td>
                                    <td>
                                        {{$item->condition->condition}}
                                    </td>
                                    <td>
                                        {{$item->price}}
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
                            <tbody>
                        </table>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>