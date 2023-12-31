<thead>
    <tr>
        <th>Auction</th>
        <th>Title</th>
        <th>Image</th>
        <th>Quantity</th>
        <th>Condition</th>
        <th>Price</th>
        <th>Created_at</th>
        <th>Auction</th>
        <th>Item</th>
        <th></th>
    </tr>
</thead>
<tbody>
@foreach ($data as $item)
    <tr>
        <td>{{$item->auctions->title}}</td>
        <td>{{$item->title}}</td>
        <td>
            @if ($item->image != null)
                @include('components.yes')
            @else
                @include('components.no')
            @endif
        </td>
        <td>{{$item->quantity}}</td>
        <td>{{$item->condition->condition}}</td>
        <td>{{$item->price}}</td>
        <td>{{$item->created_at}}</td>
        <td style="text-align: center;">
            <a href="{{ route('edit-auction', ['uuid' => $item->auction_uuid, 'route' => 'items']) }}"  class="btn btn-sm btn-dark " role="button">Edit</a>
        </td>
        <td style="text-align: center;">
            <a href="{{ route('edit-item', ['uuid' => $item->uuid, 'route' => 'items']) }}" class="btn btn-sm btn-dark " role="button">Edit</a>
        </td>
        <td>
            <form  action="{{ route('delete-item', ['uuid' => $item->uuid, 'route' => 'items']) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
</tbody>