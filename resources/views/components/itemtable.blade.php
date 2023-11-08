<table class="table table-responsive table-light table-hover  table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Active</th>
            <th scope="col">Title</th>
            <th scope="col">Price</th>
            <th scope="col">Bidders</th>
            <th scope="col">Image</th>
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
        @foreach ($all_items as $item)
            @php
            $counter++;
            @endphp
            <tr scope="row">
                <th>{{$counter}}</th>
                <td>
                    @if ($item->is_active == 1) 
                        @include('components.yes')
                    @else 
                        @include('components.no')
                    @endif
                </td>
                <td>
                    <a href="/item/{{$item->item_uuid}}" class="btn" role="button"> {{$item->title}}</a>
                </td>
                <td>
                    {{$item->current_price}}
                </td>
                <td>
                    {{$item->bidder_count}}
                </td>
                <td>
                    @if ($item->image != NULL) 
                        @include('components.yes')
                    @else 
                        @include('components.no')
                    @endif
                </td>
                <td>
                    {{$item->category}}
                </td>
                <td>
                    {{$item->condition}}
                </td>
                <td>
                    {{$item->end_time}}
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