<thead>
    <tr>
        <th>Auction</th>
        <th>Title</th>
        <th>Quantity</th>
        <th>Condition</th>
        <th>Price</th>
        <th>Created_at</th>
        <th></th>
    </tr>
</thead>
<tbody>
@foreach ($data as $item)
    <tr>
        <td>{{$item->auctions->title}}</td>
        <td>{{$item->title}}</td>
        <td>{{$item->quantity}}</td>
        <td>{{$item->condition->condition}}</td>
        <td>{{$item->price}}</td>
        <td>{{$item->created_at}}</td>
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