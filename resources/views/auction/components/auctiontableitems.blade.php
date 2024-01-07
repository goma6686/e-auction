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
            <div class="btn-group">
                <a href="{{ route('edit-item', ['uuid' => $item->uuid, 'route' => 'profile']) }}" class="btn btn-sm btn-dark " role="button">Edit</a>
                <form action="{{ route('delete-item', ['uuid' => $item->uuid, 'route' => 'profile']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this post?')">Delete</button>
                </form>
            </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
