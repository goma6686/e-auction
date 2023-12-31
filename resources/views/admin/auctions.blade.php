<thead>
    <tr>
        <th>Is Active</th>
        <th>Title</th>
        <th>Owner</th>
        <th>Category</th>
        <th>Type</th>
        <th>Item Count</th>
        <th>Bids</th>
        <th>Buy Now Price</th>
        <th>Price</th>
        <th>Reserve Price</th>
        <th>End Time</th>
        <th>Created_at</th>
        <th></th>
    </tr>
</thead>
<tbody>
@foreach ($data as $auction)
    <tr>
        <td>
            @if ($auction->is_active == 1) 
                @include('components.yes')
            @else 
                @include('components.no')
            @endif
        </td>
        <td>{{$auction->title}}</td>
        <td>{{$auction->user->email}}</td>
        <td>{{$auction->category->category}}</td>
        <td>{{$auction->type->type}}</td>
        <td>{{$auction->items_count}}</td>
        <td>{{$auction->bids_count}}</td>
        <td>
            @if ($auction->buy_now_price) 
                {{$auction->buy_now_price}}
            @else 
                @include('components.no')
            @endif
        </td>
        <td>
            @if ($auction->price) 
                {{$auction->price}}
            @else 
                Buy Now type
            @endif
        </td>
        <td>
            @if ($auction->reserve_price) 
                {{$auction->reserve_price}}
            @else 
                @include('components.no')
            @endif
        </td>
        <td>
            @if ($auction->end_time) 
                {{$auction->end_time}}
            @else 
                Buy Now type
            @endif
        </td>
        <td>{{$auction->created_at}}</td>
        <td>
            <form action="/delete-auction/{{$auction->uuid}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
</tbody>